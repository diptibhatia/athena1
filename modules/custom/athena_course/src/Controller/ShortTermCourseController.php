<?php

namespace Drupal\athena_course\Controller;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\Core\Ajax\RemoveCommand;

use \Drupal\Core\Url;

class ShortTermCourseController {

    public function shortTermCourse() {
        $limit = 16;
        $uri = "https://newlms.athena.edu/athenadev/api/courselist?page=1&limit=$limit";
        try {
            $response = \Drupal::httpClient()->get($uri, array('headers' => array('Accept' => 'application/json')));
            $data = (string)$response->getBody();
        }
        catch (RequestException $e) {
            return  [
              '#theme' => 'short_term_course',
              '#nodes' => [],
            ];
        }

        $nodes = json_decode($data);
        if (count($nodes) > 0) {
            foreach ($nodes->data as $key => $value) {
                $courses_data[] = [
                    'cid' => $value->cid,
                    'label' => $value->course_name,
                    'body' => $value->university_desc,
                    'field_rating' => '4.5',
                    'field_course_amount' => 'Free',
                    'field_certified_level' => 'CPD Certifieid',

                ];
            }
            $short_term_courses_nodes = $courses_data;
        }

        // print"<pre>"; print_r($short_term_courses_nodes); exit;

        $short_term_course =  [
          '#theme' => 'short_term_course',
          '#nodes' => $short_term_courses_nodes,
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

    public function loadMore($pager) {
        $limit = 16;
        $uri = "https://newlms.athena.edu/athenadev/api/courselist?page=$pager&limit=$limit";

        $response = \Drupal::httpClient()->get($uri, array('headers' => array('Accept' => 'application/json')));
        $data = (string)$response->getBody();

        $nodes = json_decode($data);

        $total = $nodes->total;
        $total_pages = $total/$limit;

        $response = new AjaxResponse();
        $html = '';
        if (count($nodes) > 0) {
            foreach ($nodes->data as $key => $value) {
                $courses_data = [
                    'cid' => $value->cid,
                    'label' => $value->course_name,
                    'body' => $value->university_desc,
                    'field_rating' => '4.5',
                    'field_course_amount' => 'Free',
                    'field_certified_level' => 'CPD Certifieid',
                ];

                $html .= '<div class="item content" style="display:block;">
                    <div class="course-item-hover">
                        <div class="row">
                            <div class="col-12 social-icons">
                                <a href="#"><img src="//themes/custom/athena/images/facebook.svg" /></a>
                                <a href="#"><img src="//themes/custom/athena/images/twitter.svg" class="ml-2 mr-2" /></a>
                                <a href="#"><img src="//themes/custom/athena/images/linkedin.svg" /></a>
                            </div>
                        </div>
                        <div class="course-details col-12 text-center p-0">
                            <h3>' . $courses_data['label'] . '</h3>
                            <div class="course-info">
                                <p class="small">' . $courses_data['field_certified_level'] . '</p>
                                ' . substr($courses_data['body'], 0, 100) . '...
                            </div>
                            <div class="col-12">
                                <h4><a href="#">More Information ></a></h4>
                            </div>
                            <div class="col-12">
                                <p class="small">' . $courses_data['field_students_enrolled'] . ' <em>Students Enrolled</em></p>
                            </div>
                            <div class="col-12 button-area"><button>Start Now</button></div>
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
                            <div class="col-12 button-area"><button>Start Now</button></div>
                        </div>
                    </div>
                </div>';
            }
            $response->addCommand(new AppendCommand('.shortterm-courses', $html));
        }
        if ($pager > $total_pages) {
            $response->addCommand(new RemoveCommand('#showMore'));
        }



        return $response;
    }

}
