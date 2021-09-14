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
use \Symfony\Component\HttpFoundation\Request;

class ShortTermCourseController {

    public $_limit;
    public $_lms_url;
    public $_api;

    public function __construct() {
        $this->_limit = 10;
        $this->_lms_url = CommonHelper::getConfigSettings('athena_library.common_settings', 'lms_url');
        if ( $this->_lms_url == "https://newlms.athena.edu" )
            $this->_api = "/athenadev";
        elseif ( $this->_lms_url == "https://learnstaging.athena.edu" )
            $this->_api = "/athenastg";
        else
            $this->_api = "/athenaprod";
        //$this->_lms_url = "https://newlms.athena.edu";

        // for smo pages         
        if (in_array("subject", explode("/",$_SERVER['REQUEST_URI'] ))) $this->sublist = "SubjectList";
        elseif (in_array("certificate", explode("/",$_SERVER['REQUEST_URI'] ))) $this->sublist = "CertList";

        // listing pages setting filters for main menu 
        $this->certificate_filters_request = $_REQUEST['certificate_filters'];

    }

    /**
     * List courses as per pagination.
     * @return [array]
     */
    public function shortTermCourse( $id = NULL ) {    
        
        $limit = $this->_limit;
        //$uri = "https://newlms.athena.edu/athenadev/api/courselist?page=1&page_limit=$limit";
        $uri = $this->_lms_url .$this->_api. "/api/courselist?page=1&page_limit=$limit&fk_type_of_qualification_id=1&status=1";

        if ( $this->sublist == "SubjectList" ) $uri .= "&subject_area_id=".$id;
        elseif ( $this->sublist == "CertList" ) $uri .= "&fk_certificate_type_id=".$id;
        elseif ( !empty($this->certificate_filters_request)) $uri .= "&fk_certificate_type_id=".$this->certificate_filters_request;

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

                if (($this->sublist == "SubjectList" ) || ($this->sublist == "CertList" ))
                {
                    if (!empty($value->website_image_path)) 
                        $course_image_path = $value->website_image_path;                    
                    else 
                        $course_image_path = '/themes/custom/athena/images/smo/smo-course-img.png';
                }
                else
                {
                    if (!empty($value->course_image_path)) 
                        $course_image_path = $value->course_image_path;                    
                    else 
                        $course_image_path = '/themes/custom/athena/images/course-image2.png';
                }

                $white_logo ='';
                $univ_name = '';
                foreach ($value->partner_body as $key1 => $value1) {
                    if( is_object( $value1 )) {
                        foreach($value1 as $key2 => $value2) {
                           if ( $key2 == "university_image" ) {
                                $white_logo = $value2;
                           }
                           if ( $key2 == "university_name" ) {
                                $univ_name = $value2;
                           }
                        }
                    }
                }

                $website_card_content = $value->website_card_content;
                
                
                $courses_data[] = [
                    'cid' => $value->cid,
                    'course_url' => $this->_lms_url .'/student-dashboard/course/' . $value->cid .'/'.$value->slug,
                    'label' => $value->course_name,
                    'body' => $website_card_content,
                    'card_intro' => $value->course_introduction,
                    'field_course_amount' => 'Free',
                    'white_logo' => ( $univ_name == "None" || $univ_name == '' || ( empty ( $univ_name ) == 1 ) || $white_logo == '' || ( empty ( $white_logo ) == 1 ) ) ? '' : $white_logo,
                    'univ_name' => ( $univ_name == "None" || $univ_name == '' || ( empty ( $univ_name ) == 1 )) ? '' : $univ_name, 
                    'course_image' => $course_image_path
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

        if (($this->sublist == "SubjectList" ) || ($this->sublist == "CertList" )) $theme =  "short_term_course_subject";
        else $theme =  "short_term_course";


        $short_term_course =  [
          '#theme' => $theme,
          '#nodes' => $short_term_courses_nodes,
          '#filters' => $filters,
          '#certificates' => $certificates,
          '#display_load_more' => $display_load_more,
          '#portal_url' => $this->_lms_url,
          '#certification_filter_request' => $this->certificate_filters_request,
          '#attached' => [
            'library' => [
                'core/drupal.ajax'
            ]
          ]
        ];

        $short_term_course_subject =  [
          '#SubOrCertList' => $this->sublist,
          "#id" => $id,
      ];


        if ( ($this->sublist == "SubjectList") || ($this->sublist == "CertList") )
            $short_term_course = array_merge($short_term_course,$short_term_course_subject );

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

        $subject_id = $_REQUEST['subject_id'] ?? '';
        $selected_cert_ids = $_REQUEST['selected_cert_ids'] ?? '';


        $limit = $this->_limit;

        if (!empty($search)) {
            $uri = $this->_lms_url .$this->_api. "/api/courselist?page=$pager&page_limit=$limit&fk_type_of_qualification_id=1&status=1&course_name=" . $search;
        }
        else {
            $uri = $this->_lms_url .$this->_api. "/api/courselist?page=$pager&page_limit=$limit&fk_type_of_qualification_id=1&status=1";
        }

        if ( !empty($subject_id) )
                $uri = $uri. "&subject_area_id=".$subject_id;

        if ( !empty($selected_cert_ids) && ($selected_cert_ids != "all") )
                $uri = $uri. "&fk_certificate_type_id=".$selected_cert_ids;

        $response = \Drupal::httpClient()->get($uri, array('headers' => array('Accept' => 'application/json')));
        $data = (string)$response->getBody();

        $nodes = json_decode($data);

        $total = $nodes->data->total;
        $total_pages = $total/$limit;

        $response = new AjaxResponse();
        $html = '';
        if (count($nodes) > 0) {
            foreach ($nodes->data->data as $key => $value) {
                if (!empty($value->course_image_path)) {
                    $course_image_path = $value->course_image_path;
                }
                else {

                    $course_image_path = '/themes/custom/athena/images/course-image2.png';
                }

                $white_logo = '';
                $univ_name = '';
                foreach ($value->partner_body as $key1 => $value1) {
                    if( is_object( $value1 )) {
                        foreach($value1 as $key2 => $value2) {
                           if ( $key2 == "university_image" ) {
                                $white_logo = $value2;
                           }
                           if ( $key2 == "university_name" ) {
                                $univ_name = $value2;
                           }
                        }
                    }
                }

                $website_card_content = $value->website_card_content;

                $courses_data = [
                    'cid' => $value->cid,
                    'course_url' => $this->_lms_url . '/student-dashboard/course/' . $value->cid.'/'.$value->slug,
                    'label' => $value->course_name,
                    'body' => $website_card_content,
                    'card_intro' => $value->course_introduction,
                    'field_course_amount' => 'Free',
                    'white_logo' => ( $univ_name == "None" || $univ_name == '' || ( empty ( $univ_name ) == 1 ) || $white_logo == '' || ( empty ( $white_logo ) == 1 ) ) ? '' : $white_logo,
                    'univ_name' => ( $univ_name == "None" || $univ_name == '' || ( empty ( $univ_name ) == 1 )) ? '' : $univ_name,
                    'course_image' => $course_image_path
                ];

                $image_add = ( $courses_data['univ_name'] == "" ) ? '' : '<img src="' . $courses_data['white_logo'] . '" alt="' . $courses_data['univ_name'] . '"> ';

                $html .= '<div class="flip-card">
                    <div class="flip-card-inner">
                    
                    <div class="flip-card-back">
                        <div class="row">
                            <div class="col-12 social-icons">                                

                                <a href="https://www.facebook.com/sharer.php?u='. $courses_data['course_url'] . $courses_data['cid'] .'/'.$courses_data['label'] .'&quote=Check out this course -'. $courses_data['label'] .'. '. $courses_data['course_url'] .'&title= '.$courses_data['cid'].'"   target="_blank"><img src="/themes/custom/athena/images/icons/facebook.svg" /></a>
                                
                                <a href="https://www.twitter.com/share?text=Check out this course -'. $courses_data['label'] .'. '.'&url='.$courses_data['course_url'] .'" target="_blank"><img src="/themes/custom/athena/images/icons/twitter.svg" class="ml-2 mr-2" /></a>                                

                                <a href="https://www.linkedin.com/share?mini=true&url='.$courses_data['course_url'] .'&title='.$courses_data['course_url']. $courses_data['cid'] .'/'.$courses_data['label'] .'" target="_blank"><img src="/themes/custom/athena/images/icons/linkedin.svg" class="ml-2 mr-2" /></a>                                

                            </div>
                        </div>
                        <div class="course-details col-12 text-center0 p-0">
                            <h3>' . $courses_data['label'] . '</h3>
                            <div class="course-info">
                                <p class="small">' . $courses_data['univ_name'] . '</p>
                                 
                                <span class="course-info-text"><p>' . $courses_data['body'] . '</p></span>
                            </div>
                            
                            <div class="col-12">
                                <h4><a target="_blank" href="' . $courses_data['course_url'] . '">More Information ></a></h4>
                            </div>
                            <div class="col-12 button-area"><a target="_blank" href="' . $courses_data['course_url'] . '"><button>Start Now</button></a></div>
                        </div>
                    </div>
                    <div class="flip-card-front">
                        <div class="row heading m-0">
                            <div class="col-8"> '.$image_add.'  
                            </div>
                            <div class="col-4">
                                <span class="free-text">' . $courses_data['field_course_amount'] . '</span>
                            </div>
                        </div>
                        <div class="image">

                            <img width="100%" src="' . $courses_data['course_image'] . '" alt="course-image">

                        </div>
                        <div class="course-details">
                            <h3>' . $courses_data['label'] . '</h3>
                            
                            <div class="course-info course-info-text"><p>
                               ' .  $courses_data['card_intro'] . '</p>
                            </div>
                            <div class="col-12 button-area"><a target="_blank" href="' . $courses_data['course_url'] . '"><button>Start Now</button></a></div>
                        </div>
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
     * Load more
     * @param  [int] $pager
     * @return [html]
     */
    public function SubjectloadMore($id , $pager) {
        $search = $_REQUEST['search'] ?? '';
        $search = trim($search);
        $search = strip_tags($search);

        $multiple_subject_id = $_REQUEST['multiple_subject_id'] ?? '';

        $limit = $this->_limit;

        if (!empty($search)) {


            $uri = $this->_lms_url .$this->_api. "/api/courselist?page=$pager&page_limit=$limit&fk_type_of_qualification_id=1&status=1&course_name=" . $search;
        }
        else {
            $uri = $this->_lms_url .$this->_api. "/api/courselist?page=$pager&page_limit=$limit&fk_type_of_qualification_id=1&status=1";
        }


        if ( $this->sublist == "SubjectList" )
        {
            $uri = $uri . "&subject_area_id=".$id;
            if ( !empty($multiple_subject_id) )
                $uri = $uri. "&fk_certificate_type_id=".$multiple_subject_id;
        }
        else
        {
            $uri = $uri. "&fk_certificate_type_id=".$id;
            if ( !empty($multiple_subject_id) )
                $uri = $uri. "&subject_area_id=".$multiple_subject_id;
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

                if (!empty($value->website_image_path)) {
                    $course_image_path = $value->website_image_path;
                }
                else {
                    $course_image_path = '/themes/custom/athena/images/smo/smo-course-img.png';
                }

                $white_logo = '';
                $univ_name = '';
                foreach ($value->partner_body as $key1 => $value1) {
                    if( is_object( $value1 )) {
                        foreach($value1 as $key2 => $value2) {
                           if ( $key2 == "university_image" ) {
                                $white_logo = $value2;
                           }
                           if ( $key2 == "university_name" ) {
                                $univ_name = $value2;
                           }
                        }
                    }
                }

                $website_card_content = $value->website_card_content;

                $courses_data = [
                    'cid' => $value->cid,
                    'course_url' => $this->_lms_url . '/student-dashboard/course/' . $value->cid.'/'.$value->slug,
                    'label' => $value->course_name,
                    'body' => $website_card_content,
                    'card_intro' => $value->course_introduction,
                    'field_course_amount' => 'Free',
                    'white_logo' => ( $univ_name == "None" || $univ_name == '' || ( empty ( $univ_name ) == 1 ) || $white_logo == '' || ( empty ( $white_logo ) == 1 ) ) ? '' : $white_logo,
                    'univ_name' => ( $univ_name == "None" || $univ_name == '' || ( empty ( $univ_name ) == 1 )) ? '' : $univ_name,
                    'course_image' => $course_image_path
                ];


                $image_add = ( $courses_data['univ_name'] == "" ) ? '' : '<img src="' . $courses_data['white_logo'] . '" alt="' . $courses_data['univ_name'] . '"> ';


                $html .= '<div class="item content" style="display:block;">
                            <div class="item-inner">
                                <div class="course-item">
                                    <div class="row heading m-0">
                                        <div class="col-9"> '.$image_add.'
                                        </div>
                                        <div class="col-3">
                                            <span class="free-text">' . $courses_data['field_course_amount'] . '</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="image col-md-3 pr-0">
                                            <img src="' . $courses_data['course_image'] . '" alt="course-image">
                                        </div>
                                        <div class="course-details  col-md-9">
                                            <h3>' . $courses_data['label'] . '</h3>
                                            <div class="course-info">
                                                ' . $courses_data['card_intro'] . '
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="social-icons">
                                                        
                                                        
                                                <a href="https://www.facebook.com/sharer.php?u='. $courses_data['course_url'] . $courses_data['cid'] .'/'.$courses_data['label'] .'&quote=Check out this course -'. $courses_data['label'] .'. '. $courses_data['course_url'] .'&title= '.$courses_data['cid'].'"   target="_blank"><img src="/themes/custom/athena/images/icons/facebook.svg" /></a>
                                                
                                                <a href="https://www.twitter.com/share?text=Check out this course -'. $courses_data['label'] .'. '.'&url='.$courses_data['course_url'] .'" target="_blank"><img src="/themes/custom/athena/images/icons/twitter.svg" class="ml-2 mr-2" /></a>
                                                

                                                <a href="https://www.linkedin.com/share?mini=true&url='.$courses_data['course_url'] .'&title='.$courses_data['course_url']. $courses_data['cid'] .'/'.$courses_data['label'] .'" target="_blank"><img src="/themes/custom/athena/images/icons/linkedin.svg" class="ml-2 mr-2" /></a>

                                                    </div>
                                                </div>
                                                <div class="col-6 button-area"><a target="_blank" href="' . $courses_data['course_url'] . '">
                                                    <button>Start Now &nbsp;></button></a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';

            }
            $response->addCommand(new AppendCommand('.shortterm-smo-courses', $html));
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
    public function searchCourse( $query ) {
        $response = new AjaxResponse();
        $limit = $this->_limit;
        $query = trim($query);
        $query = strip_tags($query);

        if (empty($query)) {
            $response->addCommand(new InvokeCommand('.show_more_wrapper', 'hide'));
            $response->addCommand(new HtmlCommand('.shortterm-courses', 'No Content Found'));
            return $response;
        }

        // $uri = "https://newlms.athena.edu/athenadev/api/courselist?page=1&page_limit=$limit&course_name=" . $query;
        $uri = $this->_lms_url .$this->_api. "/api/courselist?page=1&page_limit=$limit&fk_type_of_qualification_id=1&status=1" . $query;

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
                if (!empty($value->course_image_path)) {
                    $course_image_path = $value->course_image_path;
                }
                else {
                   $course_image_path = '/themes/custom/athena/images/course-image2.png';
                }

                $white_logo = '';
                $univ_name = '';
                foreach ($value->partner_body as $key1 => $value1) {
                    if( is_object( $value1 )) {
                        foreach($value1 as $key2 => $value2) {
                           if ( $key2 == "university_image" ) {
                                $white_logo = $value2;
                           }
                           if ( $key2 == "university_name" ) {
                                $univ_name = $value2;
                           }
                        }
                    }
                }

                $website_card_content = $value->website_card_content;

                $courses_data = [
                    'cid' => $value->cid,
                    'course_url' => $this->_lms_url . '/student-dashboard/course/' . $value->cid .'/'.$value->slug,
                    'label' => $value->course_name,
                    'body' => $website_card_content,
                    'card_intro' => $value->course_introduction,
                    'field_course_amount' => 'Free',
                    'white_logo' => ( $univ_name == "None" || $univ_name == '' || ( empty ( $univ_name ) == 1 ) || $white_logo == '' || ( empty ( $white_logo ) == 1 ) ) ? '' : $white_logo,
                    'univ_name' => ( $univ_name == "None" || $univ_name == '' || ( empty ( $univ_name ) == 1 )) ? '' : $univ_name,
                    'course_image' => $course_image_path
                ];

                $image_add = ( $courses_data['univ_name'] == "" ) ? '' : '<img src="' . $courses_data['white_logo'] . '" alt="' . $courses_data['univ_name'] . '"> ';


$html .= '<div class="flip-card">
                    <div class="flip-card-inner">
                    
                    <div class="flip-card-back">
                        <div class="row">
                            <div class="col-12 social-icons">                                

                                <a href="https://www.facebook.com/sharer.php?u='. $courses_data['course_url'] . $courses_data['cid'] .'/'.$courses_data['label'] .'&quote=Check out this course -'. $courses_data['label'] .'. '. $courses_data['course_url'] .'&title= '.$courses_data['cid'].'"   target="_blank"><img src="/themes/custom/athena/images/icons/facebook.svg" /></a>
                                
                                <a href="https://www.twitter.com/share?text=Check out this course -'. $courses_data['label'] .'. '.'&url='.$courses_data['course_url'] .'" target="_blank"><img src="/themes/custom/athena/images/icons/twitter.svg" class="ml-2 mr-2" /></a>                                

                                <a href="https://www.linkedin.com/share?mini=true&url='.$courses_data['course_url'] .'&title='.$courses_data['course_url']. $courses_data['cid'] .'/'.$courses_data['label'] .'" target="_blank"><img src="/themes/custom/athena/images/icons/linkedin.svg" class="ml-2 mr-2" /></a>                                

                            </div>
                        </div>
                        <div class="course-details col-12 text-center0 p-0">
                            <h3>' . $courses_data['label'] . '</h3>
                            <div class="course-info">
                                <p class="small">' . $courses_data['univ_name'] . '</p>
                                 
                                <span class="course-info-text"><p>' . $courses_data['body'] . '</p></span>
                            </div>
                            
                            <div class="col-12">
                                <h4><a target="_blank" href="' . $courses_data['course_url'] . '">More Information ></a></h4>
                            </div>
                            <div class="col-12 button-area"><a target="_blank" href="' . $courses_data['course_url'] . '"><button>Start Now</button></a></div>
                        </div>
                    </div>
                    <div class="flip-card-front">
                        <div class="row heading m-0">
                            <div class="col-8"> '.$image_add.'  
                            </div>
                            <div class="col-4">
                                <span class="free-text">' . $courses_data['field_course_amount'] . '</span>
                            </div>
                        </div>
                        <div class="image">

                            <img width="100%" src="' . $courses_data['course_image'] . '" alt="course-image">

                        </div>
                        <div class="course-details">
                            <h3>' . $courses_data['label'] . '</h3>
                            
                            <div class="course-info course-info-text"><p>
                               ' .  $courses_data['card_intro'] . '</p>
                            </div>
                            <div class="col-12 button-area"><a target="_blank" href="' . $courses_data['course_url'] . '"><button>Start Now</button></a></div>
                        </div>
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

    /**
     * Search more
     * @param  [string] $query
     * @return [html]
     */
    public function searchSubjectCourse( $id = NULL, $query ) {
        $response = new AjaxResponse();
        $limit = $this->_limit;
        $query = trim($query);
        $query = strip_tags($query);

        if (empty($query)) {
            $response->addCommand(new InvokeCommand('.show_more_wrapper', 'hide'));
            $response->addCommand(new HtmlCommand('.shortterm-courses', 'No Content Found'));
            return $response;
        }

        // $uri = "https://newlms.athena.edu/athenadev/api/courselist?page=1&page_limit=$limit&course_name=" . $query;
        $uri = $this->_lms_url .$this->_api. "/api/courselist?page=1&page_limit=$limit&fk_type_of_qualification_id=1&status=1" . $query;

        $response_data = \Drupal::httpClient()->get($uri, array('headers' => array('Accept' => 'application/json')));
        $data = (string)$response_data->getBody();

        $nodes = json_decode($data);

        $total = $nodes->data->total;
        if ($total == 0) {
            $response->addCommand(new InvokeCommand('.show_more_wrapper', 'hide'));
            $response->addCommand(new HtmlCommand('.shortterm-smo-courses', 'No Content Found'));
            return $response;
        }

        $html = '';
        if (count($nodes) > 0) {
            foreach ($nodes->data->data as $key => $value) {
                if (!empty($value->website_image_path)) {
                    $course_image_path = $value->website_image_path;
                }
                else {
                    $course_image_path = '/themes/custom/athena/images/smo/smo-course-img.png';
                }
                $white_logo = '';
                $univ_name = '';
                foreach ($value->partner_body as $key1 => $value1) {
                    if( is_object( $value1 )) {
                        foreach($value1 as $key2 => $value2) {
                           if ( $key2 == "university_image" ) {
                                $white_logo = $value2;
                           }
                           if ( $key2 == "university_name" ) {
                                $univ_name = $value2;
                           }
                        }
                    }
                }

                $website_card_content = $value->website_card_content;

                $courses_data = [
                    'cid' => $value->cid,
                    'course_url' => $this->_lms_url . '/student-dashboard/course/' . $value->cid .'/'.$value->slug,
                    'label' => $value->course_name,
                    'body' => $website_card_content,
                    'card_intro' => $value->course_introduction,
                    'field_course_amount' => 'Free',
                    'white_logo' => ( $univ_name == "None" || $univ_name == '' || ( empty ( $univ_name ) == 1 ) || $white_logo == '' || ( empty ( $white_logo ) == 1 ) ) ? '' : $white_logo,
                    'univ_name' => ( $univ_name == "None" || $univ_name == '' || ( empty ( $univ_name ) == 1 )) ? '' : $univ_name,
                    'course_image' => $course_image_path
                ];

                $image_add = ( $courses_data['univ_name'] == "" ) ? '' : '<img src="' . $courses_data['white_logo'] . '" alt="' . $courses_data['univ_name'] . '"> ';


                $html .= '<div class="item content" style="display:block;">
                            <div class="item-inner">
                                <div class="course-item">
                                    <div class="row heading m-0">
                                        <div class="col-9"> '. $image_add .'
                                        </div>
                                        <div class="col-3">
                                            <span class="free-text">' . $courses_data['field_course_amount'] . '</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="image col-md-3 pr-0">
                                            <img src="' . $courses_data['course_image'] . '" alt="course-image">
                                        </div>
                                        <div class="course-details  col-md-8">
                                            <h3>' . $courses_data['label'] . '</h3>
                                            <div class="course-info course-info-text">
                                                ' . $courses_data['card_intro'] . '
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="social-icons">
                                                        
                                                        
                                                <a href="https://www.facebook.com/sharer.php?u='. $courses_data['course_url'] . $courses_data['cid'] .'/'.$courses_data['label'] .'&quote=Check out this course -'. $courses_data['label'] .'. '. $courses_data['course_url'] .'&title= '.$courses_data['cid'].'"   target="_blank"><img src="/themes/custom/athena/images/icons/facebook.svg" /></a>
                                                
                                                <a href="https://www.twitter.com/share?text=Check out this course -'. $courses_data['label'] .'. '.'&url='.$courses_data['course_url'] .'" target="_blank"><img src="/themes/custom/athena/images/icons/twitter.svg" class="ml-2 mr-2" /></a>
                                                

                                                <a href="https://www.linkedin.com/share?mini=true&url='.$courses_data['course_url'] .'&title='.$courses_data['course_url']. $courses_data['cid'] .'/'.$courses_data['label'] .'" target="_blank"><img src="/themes/custom/athena/images/icons/linkedin.svg" class="ml-2 mr-2" /></a>

                                                                    </div>
                                                </div>
                                                <div class="col-6 button-area"><a target="_blank" href="' . $courses_data['course_url'] . '">
                                                    <button>Start Now &nbsp;></button></a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';

            }
            $response->addCommand(new HtmlCommand('.shortterm-smo-courses', $html));
        }

        if ($total <= $limit) {
            $response->addCommand(new InvokeCommand('.show_more_wrapper', 'hide'));
        }
        else {
         $response->addCommand(new InvokeCommand('.show_more_wrapper', 'show'));
        }

        return $response;
    }
    /**
     * List courses as per pagination.
     * @return [html]
     */
    public function shorttermCourseList(Request $request) {
        $subject_id = $request->query->get('subject_id');
        $current_page = $request->query->get('current_page');
        $total = $request->query->get('total');
        $pages = ceil($total/10);
        $next_page = $current_page+1;
        if($pages >= $next_page) {
            $uri = $this->_lms_url .$this->_api. "/api/courselist?page=".$next_page."&page_limit=10&fk_type_of_qualification_id=1&status=1&subject_area_id=".$subject_id; 
            $html = "";
            try {
                $response = \Drupal::httpClient()->get($uri, array('headers' => array('Accept' => 'application/json')))->getBody();
                $all_data = json_decode($response);

                $courses = json_decode($all_data->data, TRUE);
                if($all_data->status == 200) {
                    $related_courses = $all_data->data->data;
                    $total = $all_data->data->total;
                    $current_page = $all_data->data->current_page;
                    foreach ($related_courses as $course) {
                        $url = $this->_lms_url . '/student-dashboard/course/' . $course->cid .'/'.$course->slug;

                        $white_logo = '';
                        $univ_name = '';
                        foreach ($course->partner_body as $key1 => $value1) {
                            if( is_object( $value1 )) {
                                foreach($value1 as $key2 => $value2) {
                                if ( $key2 == "university_image" ) {
                                        $white_logo = $value2;
                                }
                                if ( $key2 == "university_name" ) {
                                        $univ_name = $value2;
                                }
                                }
                            }
                        }
                        
                        $course_amount = ($course->field_course_amount != "") ?  $course->field_course_amount : 'Free';

                        $image_add = ( $courses_data['univ_name'] == "" ) ? '' : '<img src="' . $courses_data['white_logo'] . '" alt="' . $courses_data['univ_name'] . '"> ';


                        $html .= '<div class="item content" style="display:block;">
                        <div class="item-inner">
                        <div class="course-item-hover" style="padding:22px 15px 18px;">
                            <div class="row">
                                <div class="col-12 social-icons">
                            
                                
                                <a href="https://www.facebook.com/sharer.php?u='. $courses_data['course_url'] . $courses_data['cid'] .'/'.$courses_data['label'] .'&quote=Check out this course -'. $courses_data['label'] .'. '. $courses_data['course_url'] .'&title= '.$courses_data['cid'].'"   target="_blank"><img src="/themes/custom/athena/images/icons/facebook.svg" /></a>
                                
                                <a href="https://www.twitter.com/share?text=Check out this course -'. $courses_data['label'] .'. '.'&url='.$courses_data['course_url'] .'" target="_blank"><img src="/themes/custom/athena/images/icons/twitter.svg" class="ml-2 mr-2" /></a>
                                

                                <a href="https://www.linkedin.com/share?mini=true&url='.$courses_data['course_url'] .'&title='.$courses_data['course_url']. $courses_data['cid'] .'/'.$courses_data['label'] .'" target="_blank"><img src="/themes/custom/athena/images/icons/linkedin.svg" class="ml-2 mr-2" /></a>
                                
                                </div>
                            </div>
                            <div class="course-details col-12 text-center0 p-0">
                                <h3>' . $course->course_name . '</h3>
                                <div class="course-info">
                                    <p class="small">' . $course->university_name . '</p>
                                    ' . put_dots_in_string($course->course_overview, 150) . '
                                </div>
                                <div class="col-12">
                                    <h4><a target="_blank" href="' . $url . '">More Information ></a></h4>
                                </div>
                                <div class="col-12 button-area"><a target="_blank" href="' . $url . '"><button>Start Now</button></a></div>
                            </div>
                        </div>
                        <div class="course-item">
                            <div class="row heading m-0">
                                <div class="col-9"> '. $image_add .'
                                    
                                </div>
                                <div class="col-3">
                                    <span class="free-text">' . $course_amount . '</span>
                                </div>
                            </div>
                            <div class="image">

                                <img width="100%" src="' . $course->course_image_path . '" alt="course-image">

                            </div>
                            <div class="course-details">
                                <h3>' . $course->course_name . '</h3>
                                <div class="course-info">
                                    ' . put_dots_in_string($course->course_introduction, 150) . '
                                </div>
                                <div class="col-12 button-area"><a target="_blank" href="'.$url.'"><button>Start Now</button></a></div>
                            </div>
                        </div>
                    </div>
                    </div>';        
                    }
                }

            }
            catch (\Exception $e) {
                \Drupal::logger('type')->error($e->getMessage());
            }
            return [
                '#markup' => '<div class="cards">'.$html.'</div><p id="current_page">'.$next_page.'<p>',
            ];
        }
        
    }
}
