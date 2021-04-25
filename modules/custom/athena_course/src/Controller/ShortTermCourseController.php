<?php

namespace Drupal\athena_course\Controller;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\Core\Ajax\RemoveCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use \Drupal\athena_library\Utils\CommonHelper;
use \Drupal\Core\Url;

class ShortTermCourseController {

    public $_limit;
    public $_lms_url;
    public $_api;

    public function __construct() {
        $this->_limit = 10;
        $this->_lms_url = CommonHelper::getConfigSettings('athena_library.common_settings', 'lms_url');
        if ( $this->_lms_url == "https://newlms.athena.edu" )
            $this->_api = "/athenadev";
        else
            $this->_api = "/athenaprod";
        //$this->_lms_url = "https://newlms.athena.edu";
    }

    /**
     * List courses as per pagination.
     * @return [array]
     */
    public function shortTermCourse() {
        $limit = $this->_limit;
        //$uri = "https://newlms.athena.edu/athenadev/api/courselist?page=1&limit=$limit";
        $uri = $this->_lms_url .$this->_api. "/api/courselist?page=1&limit=$limit&fk_type_of_qualification_id=1&status=1";
        try {
            $response = \Drupal::httpClient()->get($uri, array('headers' => array('Accept' => 'application/json')));
            $data = (string)$response->getBody();

            $filters_uri = $this->_lms_url .$this->_api. "/api/get_master_table_data?table=subject_area";
            $response_filters = \Drupal::httpClient()->get($filters_uri, array('headers' => array('Accept' => 'application/json')));
            $data_filters = (string)$response_filters->getBody();
            $filters = json_decode($data_filters, TRUE);

            $certificates_uri = $this->_lms_url .$this->_api. "/api/get_master_table_data?table=certification_type";
            $response_certificates = \Drupal::httpClient()->get($certificates_uri, array('headers' => array('Accept' => 'application/json')));
            $certificate_filters = (string)$response_certificates->getBody();
            $certificates = json_decode($certificate_filters, TRUE);

        }
        catch (RequestException $e) {
            return  [
              '#theme' => 'short_term_course',
              '#nodes' => [],
            ];
        }

        $nodes = json_decode($data);
        if (count($nodes) > 0) {
            foreach ($nodes->data->data as $key => $value) {
                $courses_data[] = [
                    'cid' => $value->cid,
                    'course_url' => $this->_lms_url .'/dashboard/course-details?id=' . $value->cid,
                    'label' => $value->course_name,
                    'body' => substr($value->course_introduction, 0, 100),
                    'field_rating' => rand(4, 5),
                    'field_course_amount' => 'Free',
                    'field_certified_level' => 'CPD Certifieid',

                ];
            }
            $short_term_courses_nodes = $courses_data;
        }

        // print"<pre>"; print_r($short_term_courses_nodes); exit;

        $display_load_more = TRUE;
        $total = $nodes->data->total;

        if ($total <= $limit) {
            $display_load_more = FALSE;
        }

        $short_term_course =  [
          '#theme' => 'short_term_course',
          '#nodes' => $short_term_courses_nodes,
          '#filters' => $filters,
          '#certificates' => $certificates,
          '#display_load_more' => $display_load_more,
          '#portal_url' => $this->_lms_url,
          '#attached' => [
            'library' => [
                'core/drupal.ajax'
            ]
          ]
        ];
        return array(
           $short_term_course
        );
    }

    /**
     * Load more
     * @param  [int] $pager
     * @return [html]
     */
    public function loadMore($pager) {
        $search = $_REQUEST['search'] ?? '';
        $search = trim($search);
        $search = strip_tags($search);

        $limit = $this->_limit;

        if (!empty($search)) {
            $uri = $this->_lms_url .$this->_api. "/api/courselist?page=$pager&limit=$limit&fk_type_of_qualification_id=1&status=1&course_name=" . $search;
        }
        else {
            $uri = $this->_lms_url .$this->_api. "/api/courselist?page=$pager&limit=$limit&fk_type_of_qualification_id=1&status=1";
        }

        $response = \Drupal::httpClient()->get($uri, array('headers' => array('Accept' => 'application/json')));
        $data = (string)$response->getBody();

        $nodes = json_decode($data);

        $total = $nodes->data->total;
        $total_pages = $total/$limit;

        $response = new AjaxResponse();
        $html = '';
        if (count($nodes) > 0) {
            foreach ($nodes->data->data as $key => $value) {
                $courses_data = [
                    'cid' => $value->cid,
                    'course_url' => $this->_lms_url . '/dashboard/course-details?id=' . $value->cid,
                    'label' => $value->course_name,
                    'body' => substr($value->course_introduction, 0, 100),
                    'field_rating' => rand(4, 5),
                    'field_course_amount' => 'Free',
                    'field_certified_level' => 'CPD Certifieid',
                ];

                $html .= '<div class="item content" style="display:block;">
                    <div class="course-item-hover">
                        <div class="row">
                            <div class="col-12 social-icons">
                                <a href="https://www.facebook.com/sharer.php?u='. $courses_data['course_url'] .'" target="_blank"><img src="/themes/custom/athena/images/icons/facebook.svg" /></a>
                                <a href="https://www.twitter.com/share?url='. $courses_data['course_url'] .'" target="_blank"><img src="/themes/custom/athena/images/icons/twitter.svg" class="ml-2 mr-2" /></a>
                                <a href="http://www.linkedin.com/shareArticle?mini=true&url='. $courses_data['course_url'] .'" target="_blank"><img src="/themes/custom/athena/images/icons/linkedin.svg" /></a>
                            </div>
                        </div>
                        <div class="course-details col-12 text-center p-0">
                            <h3>' . $courses_data['label'] . '</h3>
                            <div class="course-info">
                                <p class="small">' . $courses_data['field_certified_level'] . '</p>
                                ' . substr($courses_data['body'], 0, 100) . '...
                            </div>
                            <div class="col-12">
                                <h4><a target="_blank" href="' . $courses_data['course_url'] . '">More Information ></a></h4>
                            </div>
                            <div class="col-12">
                                <p class="small">' . $courses_data['field_students_enrolled'] . ' <em>Students Enrolled</em></p>
                            </div>
                            <div class="col-12 button-area"><a target="_blank" href="' . $courses_data['course_url'] . '"><button>Start Now</button></a></div>
                        </div>
                    </div>
                    <div class="course-item">
                        <div class="row heading m-0">
                            <div class="col-8">
                                <h5>' . $courses_data['field_certified_level'] . '</h5>
                            </div>
                            <div class="col-4">
                                <span class="free-text">' . $courses_data['field_course_amount'] . '</span>
                            </div>
                        </div>
                        <div class="image">

                            <img src="/themes/custom/athena/images/course-image2.png" alt="course-image">

                        </div>
                        <div class="course-details">
                            <h3>' . $courses_data['label'] . '</h3>
                            <div class="course-info">
                                ' . substr($courses_data['body'], 0, 100) . '...
                            </div>
                            <div class="row rating m-0">
                                <div class="col-6 p-0">
                                    <div class="my-rating"></div>
                                </div>
                                <div class="col-2 p-0">' . $courses_data['field_rating'] . '</div>
                            </div>
                            <div class="col-12 button-area"><a target="_blank" href="' . $courses_data['course_url'] . '"><button>Start Now</button></a></div>
                        </div>
                    </div>
                </div>';
            }
            $response->addCommand(new AppendCommand('.shortterm-courses', $html));
        }

        if ($pager > $total_pages) {
            $response->addCommand(new InvokeCommand('.show_more_wrapper', 'hide'));
        }


        return $response;
    }

    /**
     * Search more
     * @param  [string] $query
     * @return [html]
     */
    public function searchCourse($query) {
        $response = new AjaxResponse();
        $limit = $this->_limit;
        $query = trim($query);
        $query = strip_tags($query);

        if (empty($query)) {
            $response->addCommand(new InvokeCommand('.show_more_wrapper', 'hide'));
            $response->addCommand(new HtmlCommand('.shortterm-courses', 'No Content Found'));
            return $response;
        }

        // $uri = "https://newlms.athena.edu/athenadev/api/courselist?page=1&limit=$limit&course_name=" . $query;
        $uri = $this->_lms_url .$this->_api. "/api/courselist?page=1&limit=$limit&fk_type_of_qualification_id=1&status=1" . $query;

        $response_data = \Drupal::httpClient()->get($uri, array('headers' => array('Accept' => 'application/json')));
        $data = (string)$response_data->getBody();

        $nodes = json_decode($data);

        $total = $nodes->data->total;
        if ($total == 0) {
            $response->addCommand(new InvokeCommand('.show_more_wrapper', 'hide'));
            $response->addCommand(new HtmlCommand('.shortterm-courses', 'No Content Found'));
            return $response;
        }

        $html = '';
        if (count($nodes) > 0) {
            foreach ($nodes->data->data as $key => $value) {
                $courses_data = [
                    'cid' => $value->cid,
                    'course_url' => $this->_lms_url . '/dashboard/course-details?id=' . $value->cid,
                    'label' => $value->course_name,
                    'body' => substr($value->course_introduction, 0, 100),
                    'field_rating' => rand(4, 5),
                    'field_course_amount' => 'Free',
                    'field_certified_level' => 'CPD Certifieid',
                ];

                $html .= '<div class="item content" style="display:block;">
                    <div class="course-item-hover">
                        <div class="row">
                            <div class="col-12 social-icons">
                                <a href="https://www.facebook.com/sharer.php?u='. $courses_data['course_url'] .'" target="_blank"><img src="/themes/custom/athena/images/icons/facebook.svg" /></a>
                                <a href="https://www.twitter.com/share?url='. $courses_data['course_url'] .'" target="_blank"><img src="/themes/custom/athena/images/icons/twitter.svg" class="ml-2 mr-2" /></a>
                                <a href="http://www.linkedin.com/shareArticle?mini=true&url='. $courses_data['course_url'] .'" target="_blank"><img src="/themes/custom/athena/images/icons/linkedin.svg" /></a>
                            </div>
                        </div>
                        <div class="course-details col-12 text-center p-0">
                            <h3>' . $courses_data['label'] . '</h3>
                            <div class="course-info">
                                <p class="small">' . $courses_data['field_certified_level'] . '</p>
                                ' . substr($courses_data['body'], 0, 100) . '...
                            </div>
                            <div class="col-12">
                                <h4><a target="_blank" href="' . $courses_data['course_url'] . '">More Information ></a></h4>
                            </div>
                            <div class="col-12">
                                <p class="small">' . $courses_data['field_students_enrolled'] . ' <em>Students Enrolled</em></p>
                            </div>
                            <div class="col-12 button-area"><a target="_blank" href="' . $courses_data['course_url'] . '"><button>Start Now</button></a></div>
                        </div>
                    </div>
                    <div class="course-item">
                        <div class="row heading m-0">
                            <div class="col-8">
                                <h5>' . $courses_data['field_certified_level'] . '</h5>
                            </div>
                            <div class="col-4">
                                <span class="free-text">' . $courses_data['field_course_amount'] . '</span>
                            </div>
                        </div>
                        <div class="image">

                            <img src="/themes/custom/athena/images/course-image2.png" alt="course-image">

                        </div>
                        <div class="course-details">
                            <h3>' . $courses_data['label'] . '</h3>
                            <div class="course-info">
                                ' . substr($courses_data['body'], 0, 100) . '...
                            </div>
                            <div class="row rating m-0">
                                <div class="col-6 p-0">
                                    <div class="my-rating"></div>
                                </div>
                                <div class="col-2 p-0">' . $courses_data['field_rating'] . '</div>
                            </div>
                            <div class="col-12 button-area"><a target="_blank" href="' . $courses_data['course_url'] . '"><button>Start Now</button></a></div>
                        </div>
                    </div>
                </div>';
            }
            $response->addCommand(new HtmlCommand('.shortterm-courses', $html));
        }

        if ($total <= $limit) {
            $response->addCommand(new InvokeCommand('.show_more_wrapper', 'hide'));
        }
        else {
         $response->addCommand(new InvokeCommand('.show_more_wrapper', 'show'));
        }

        return $response;
    }
}
