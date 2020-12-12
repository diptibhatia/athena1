<?php
namespace Drupal\athena_course\Controller;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\Component\Serialization\Json;

use \Drupal\Core\Url;

class AthenaCourseController {

public function news_subscription(){

}

public function smo_tq(){
    if(isset($_REQUEST['nid'])){
    $node = Node::load($_REQUEST['nid']);
    }
       global $base_url;
    $theme = \Drupal::theme()->getActiveTheme();
    $base_path = $base_url.'/'. $theme->getPath();

    $source = $_REQUEST['utm_source'];
$campaign = $_REQUEST['utm_campaign'];
$academic =  [
  '#theme' => 'smotq',
  '#source' => $source,
  '#campaign' => $campaign,
  '#node' => $node,
  '#base_path' => $base_path,
];


return array($academic);


}
public function smo($nid) {
    $parameters = \Drupal::routeMatch()->getParameters();
    $node = Node::load($nid);

    global $base_url;
    $theme = \Drupal::theme()->getActiveTheme();
    $base_path = $base_url.'/'. $theme->getPath();
    //print $node->get('field_courses_credit_type')->value;exit;

     if(is_object( $node->field_link_universities)){

    $paragraph_univ_data = $node->field_link_universities->referencedEntities();
    }


foreach($paragraph_univ_data as $explore_data) {

        $university_nid = $explore_data->get('field_university')->value;
        $university_nid = $explore_data->get('field_university')->value;
        $message = $explore_data->get('field_message')->value;
        $msg_title = $explore_data->get('field_message_title')->value;
        $prof_name = $explore_data->get('field_professor_name')->value;
        $prof_univ = $explore_data->get('field_prof_university')->value;
        $dean_univ = $explore_data->get('field_dean_un')->value;
        $dean_video = $explore_data->get('field_dean_video')->value;
        $dean_message = $explore_data->get('field_dean_message_la')->value;
         if(is_object(  $explore_data->get('field_rector_image')->entity)){
        $rector = $explore_data->get('field_rector_image')->entity->getFileUri();
       $rectorurl = file_create_url($rector);
         }
       $certificates = array();
       foreach($explore_data->get('field_certificate') as $key=>$images) {

           $certificates[]  = file_create_url($images->entity->getFileUri());
       }

        //print "abcs"
    //   print_r($certificates);

        if (!empty($university_nid)) {
       $univ_node = Node::load($university_nid);
       $white_log  = '';
       switch($univ_node->get('title')->value){
           case 'Scottish Qualifications Authority, UK':
             $white_log = "sqalogo";
             break;
           case 'Guglielmo Marconi University, Italy':
           $white_log = "gmu-white";
             break;
           case 'Cambridge International Qualifications, UK':
           $white_log = "ciq-white";
             break;

            case 'Universidad Catolica De Murcia (UCAM), Spain':
                       $white_log = "ucam-logo";
                         break;

            case 'Chartered Management Institute, UK':
                       $white_log = "cmi-white";
                         break;
            default:
                    break;



       }



}
       $univ_logo = file_create_url($univ_node->get('field_logo')->entity->uri->value);
        $univ_data[] = array(
        'university' =>Node::load($university_nid),
        'certificates' =>$certificates,
        'recortimage' =>$rectorurl,
        'white_log' =>$white_log,
        'univ_logo' =>$univ_logo,
        'message' =>$message,
        'msg_title' =>$msg_title,
        'prof_name' =>$prof_name,
        'prof_univ' =>$prof_univ,
        'dean_univ' =>$dean_univ,
        'dean_video' =>$dean_video,
        'dean_message' =>$dean_message,

        );
        }


//exitl
$paragraph_why_course = $node->field_what_you_get->referencedEntities();
$why_course = array();
//print_r($paragraph_why_course);exit;
foreach($paragraph_why_course as $why_course_data) {
	$degree = $why_course_data->get('field_degree')->value;
	$issued_by = $why_course_data->get('field_issued_by')->value;

    $logo_url = '';
    if(is_object( $why_course_data->get('field_logo')->entity)){
	$logo = $why_course_data->get('field_logo')->entity->getFileUri();
    }
	$logo_url = file_create_url($logo);
    $certificates_url = '';
    if(is_object( $why_course_data->get('field_sample_certification')->entity)){
	$certificate = $why_course_data->get('field_sample_certification')->entity->getFileUri();
	$certificates_url = file_create_url($certificate);
    }

    if(empty($logo)) {
       $logo_url = $base_path."/images/coursepage/degree-mba.svg";
    }
	$why_course[] = array(
	  'degree' => $degree,
	  'issued_by' => $issued_by,
	  'logo_url' => $logo_url,
	  'certificates_url' => $certificates_url,
	);
}

//print_r($why_course);exit;

$paragraph_course_team = $node->field_course_team_member->referencedEntities();
$course_team = array();
foreach($paragraph_course_team as $attached_node){
  $name =  $attached_node->get('title')->value;
  $designation =  $attached_node->get('field_designation')->value;
  $linked_in =  $attached_node->get('field_linked_in_link')->value;
  $user_pic= '';
  if(is_object( $attached_node->get('field_user_photo')->entity)){
	$user_pic = $attached_node->get('field_user_photo')->entity->getFileUri();
    }
	$user_pic_url = file_create_url($user_pic);
  $description =  $attached_node->get('field_user_description')->value;
  $course_team[] = array(
  'name' => $name,
  'designation' => $designation,
  'user_pic' => $user_pic_url,
  'linked_in' => $linked_in,
  'description' => $description,
  );

}

$paragraph_faq = $node->field_faq->referencedEntities();
$faq = array();


foreach($paragraph_faq as $faq_data){
    //print $faq_data->get('field_category')->value;

    if(!empty($faq_data->get('field_category')->value)) {
    $faq[$faq_data->get('field_category')->value][] = array(
       'question' => $faq_data->get('field_question')->value,
       'answer' => $faq_data->get('field_answer')->value
    );
    }


}

$testibundle='testimonials';
$testiquery = \Drupal::entityQuery('node');
$testiquery->condition('status', 1);
$testiquery->condition('type', $testibundle);
$latest = $testiquery->execute();
$testinodes = node_load_multiple($latest);
$testimo =  array_slice($testinodes, 0, 7);

$source = $_REQUEST['utm_source'];
$campaign = $_REQUEST['utm_campaign'];

    $banner_block =  [
      '#theme' => 'smo',
      '#course_title' => $node->get('title')->value,
      '#ects_credit' => $node->get('field_course_ects_credit')->value,
      '#awarding_body' => $node->get('field_course_awarding_body')->value,
      '#source' => $source,
      '#campaign' => $campaign,
      '#description' => $node->get('field_course_banner_description')->value,
      '#category' => $node->get('field_course_category')->value,
     // '#banner' => $node->get('field_course_banner_image')->entity->uri->value,
      '#base_path' => $base_path,
      '#node' => $node,
      '#overview' => $node->get('field_course_overview')->value,
  '#testi' => $testimo,
  '#node' => $node,
  '#total_fee' => $node->get('field_course_total_fee')->value,
  '#univ_data' => $univ_data,
  '#logo' => $univ_data,
  '#course_team' => $course_team,
  '#faq' => $faq,
  '#why_course' => $why_course,
  '#duration' => $node->get('field_course_duration')->value,
  '#certification_label' => $node->get('field_course_certification_label')->value,
  '#certification' => $node->get('field_course_certification')->value,
  '#accreditations' => $node->get('field_course_accreditations')->value,
  '#course_details' => $node->get('field_course_details')->value,
  '#course_modules' => $node->get('field_course_modules')->value,
  '#total_credits' => $node->get('field_course_total_credits')->value,
  '#academic_route' => $node->get('field_course_academic_route')->value,
  '#academic_route_desc' => $node->get('field_course_academic_route_desc')->value,
  '#mature_entry_label' => $node->get('field_course_mature_entry_label')->value,
  '#mature_entry_desc' => $node->get('field_course_mature_desc')->value,
  '#language_prof_label' => $node->get('field_course_language_prof_label')->value,
  '#language_prof_desc' => $node->get('field_course_language_prof_desc')->value,
  '#why_athena' => $node->get('field_course_why_athena')->value,

    ];

    return array(
       $banner_block,
    );
}


  public function course($nid) {
    // New D8 procedural code.
   $parameters = \Drupal::routeMatch()->getParameters();

$node = Node::load($nid);
// print_r($node);exit;
// Base theme path.
global $base_url;
$theme = \Drupal::theme()->getActiveTheme();
$base_path = $base_url.'/'. $theme->getPath();

//print $node->get('field_courses_credit_type')->value;exit;

if(is_object( $node->field_link_universities)){
$paragraph_univ_data = $node->field_link_universities->referencedEntities();
  }

foreach($paragraph_univ_data as $explore_data) {

        $university_nid = $explore_data->get('field_university')->value;
        $university_nid = $explore_data->get('field_university')->value;
        $message = $explore_data->get('field_message')->value;
        $msg_title = $explore_data->get('field_message_title')->value;
        $prof_name = $explore_data->get('field_professor_name')->value;
        $rector_image = $explore_data->get('field_professor_name')->value;
        $prof_univ = $explore_data->get('field_prof_university')->value;
        $dean_univ = $explore_data->get('field_dean_un')->value;
        $dean_video = $explore_data->get('field_dean_video')->value;
        $dean_message = $explore_data->get('field_dean_message_la')->value;
          if(is_object( $explore_data->get('field_rector_image')->entity)){
        $recortimage = $explore_data->get('field_rector_image')->entity->getFileUri();
          }
          if (!empty($recortimage)){
     $recortimage = file_create_url($recortimage);
          }
       $certificates = array();
       foreach($explore_data->get('field_certificate') as $key=>$images) {

           $certificates[]  = file_create_url($images->entity->getFileUri());
       }

        //print "abcs"
       //print_r($certificates);exit;

        if (!empty($university_nid)) {
       $univ_node = Node::load($university_nid);
       $univ_logo = file_create_url($univ_node->get('field_logo')->entity->uri->value);


       $white_log  = '';
       switch($univ_node->get('title')->value){
           case 'Scottish Qualifications Authority, UK':
             $white_log = "sqalogo";
             break;
           case 'Guglielmo Marconi University, Italy':
           $white_log = "gmu-white";
             break;
           case 'Cambridge International Qualifications, UK':
           $white_log = "ciq-white";
             break;

            case 'Universidad Catolica De Murcia (UCAM), Spain':
                       $white_log = "ucam-logo";
                         break;

            case 'Chartered Management Institute, UK':
                       $white_log = "cmi-white";
                         break;
            default:
                    break;



       }

        $univ_data[] = array(
        'university' =>Node::load($university_nid),
        'certificates' =>$certificates,
        'univ_logo' =>$univ_logo,
        'white_log' =>$white_log,
        'message' =>$message,
        'msg_title' =>$msg_title,
        'prof_name' =>$prof_name,
        'prof_univ' =>$prof_univ,
        'dean_univ' =>$dean_univ,
        'dean_video' =>$dean_video,
        'dean_message' =>$dean_message,
        'recortimage' =>$recortimage,

        );
        }




}
if(is_object( $node->field_what_you_get)){
$paragraph_why_course = $node->field_what_you_get->referencedEntities();
}
$why_course = array();
//print_r($paragraph_why_course);exit;
foreach($paragraph_why_course as $why_course_data) {
	$degree = $why_course_data->get('field_degree')->value;
	$issued_by = $why_course_data->get('field_issued_by')->value;

    $logo_url = '';
    if(is_object( $why_course_data->get('field_logo')->entity)){
	$logo = $why_course_data->get('field_logo')->entity->getFileUri();
    }
	$logo_url = file_create_url($logo);
       $certificates_url = '';
    if(is_object( $why_course_data->get('field_sample_certification')->entity)){
	$certificate = $why_course_data->get('field_sample_certification')->entity->getFileUri();
	$certificates_url = file_create_url($certificate);
    }

    if(empty($logo)) {
       $logo_url = $base_path."/images/coursepage/degree-mba.svg";
    }
	$why_course[] = array(
	  'degree' => $degree,
	  'issued_by' => $issued_by,
	  'logo_url' => $logo_url,
	  'certificates_url' => $certificates_url,
	);
}

//print_r($why_course);exit;
if(is_object( $node->field_course_team_member)){
$paragraph_course_team = $node->field_course_team_member->referencedEntities();
}
$course_team = array();
foreach($paragraph_course_team as $attached_node){
  $name =  $attached_node->get('title')->value;
  $course_nid =  $attached_node->id();
  $designation =  $attached_node->get('field_designation')->value;
  $linked_in =  $attached_node->get('field_linked_in_link')->value;
  $user_pic= '';
  if(is_object( $attached_node->get('field_user_photo')->entity)){
	$user_pic = $attached_node->get('field_user_photo')->entity->getFileUri();
    }
	$user_pic_url = file_create_url($user_pic);
  $description =  $attached_node->get('field_user_description')->value;
  $course_team[] = array(
  'name' => $name,
  'designation' => $designation,
  'user_pic' => $user_pic_url,
  'linked_in' => $linked_in,
  'description' => $description,
  'course_nid' => $course_nid,
  );

}
if(is_object( $node->field_faq)){
$paragraph_faq = $node->field_faq->referencedEntities();
}
$faq = array();


foreach($paragraph_faq as $faq_data){
    //print $faq_data->get('field_category')->value;

    if(!empty($faq_data->get('field_category')->value)) {
    $faq[$faq_data->get('field_category')->value][] = array(
       'question' => $faq_data->get('field_question')->value,
       'answer' => $faq_data->get('field_answer')->value
    );
    }


}
$banner = '';
$banner_pic_url = '';
 if(is_object( $node->get('field_course_banner_image')->entity)){
	$banner_pic =$node->get('field_course_banner_image')->entity->uri->value;
//$banner_pic = $node->get('field_course_banner_image')->entity->getFileUri();
  $banner_pic_url = file_create_url($banner_pic);
    }



$banner_block =  [
  '#theme' => 'course_banner',
  '#course_title' => $node->get('title')->value,
  '#ects_credit' => $node->get('field_course_ects_credit')->value,
  '#univ_data' => $univ_data,
  '#awarding_body' => $node->get('field_course_awarding_body')->value,
  '#description' => $node->get('field_course_banner_description')->value,
  '#category' => $node->get('field_course_category')->value,
  '#banner' => $banner_pic_url,
  '#base_path' => $base_path,
  '#node' => $node
];

$testibundle='testimonials';
$testiquery = \Drupal::entityQuery('node');
$testiquery->condition('status', 1);
$testiquery->condition('type', $testibundle);
$latest = $testiquery->execute();
$testinodes = node_load_multiple($latest);
$testimo =  array_slice($testinodes, 0, 7);

$course_description_tabs =  [
  '#theme' => 'course_description_tabs',
  '#overview' => $node->get('field_course_overview')->value,
  '#testi' => $testimo,
  '#node' => $node,
  '#total_fee' => $node->get('field_course_total_fee')->value,
  '#univ_data' => $univ_data,
  '#logo' => $univ_data,
  '#course_title' => $node->get('title')->value,
  '#course_team' => $course_team,
  '#faq' => $faq,
  '#why_course' => $why_course,
  '#duration' => $node->get('field_course_duration')->value,
  '#certification_label' => $node->get('field_course_certification_label')->value,
  '#certification' => $node->get('field_course_certification')->value,
  '#accreditations' => $node->get('field_course_accreditations')->value,
  '#course_details' => $node->get('field_course_details')->value,
  '#course_modules' => $node->get('field_course_modules')->value,
  '#total_credits' => $node->get('field_course_total_credits')->value,
  '#academic_route' => $node->get('field_course_academic_route')->value,
  '#academic_route_desc' => $node->get('field_course_academic_route_desc')->value,
  '#mature_entry_label' => $node->get('field_course_mature_entry_label')->value,
  '#mature_entry_desc' => $node->get('field_course_mature_desc')->value,
  '#language_prof_label' => $node->get('field_course_language_prof_label')->value,
  '#language_prof_desc' => $node->get('field_course_language_prof_desc')->value,
  '#why_athena' => $node->get('field_course_why_athena')->value,
    '#base_path' => $base_path,
];

return array(
   $banner_block,
   $course_description_tabs,
);

  }

  public function registration() {
    // New D8 procedural code.
   $parameters = \Drupal::routeMatch()->getParameters();

     $bundle='course';
     $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
    $query->condition('type', $bundle);
    $entity_ids = $query->execute();
if(!empty($entity_ids)) {
$nodes = node_load_multiple($entity_ids);
}


//$node = Node::load($nid);

// Base theme path.
global $base_url;
$theme = \Drupal::theme()->getActiveTheme();
$base_path = $base_url.'/'. $theme->getPath();

$cid = '';
if(isset($_REQUEST['cid'])) {
    $cid = $_REQUEST['cid'];
}
$source = $_REQUEST['utm_source'];
$campaign = $_REQUEST['utm_campaign'];

//print_r($node);exit;
$registration =  [
  '#theme' => 'course_registration',
  '#base_path' => $base_path,
  '#source' => $source,
  '#campaign' => $campaign,
  '#cid' => $cid,
  '#nodes' => $nodes,
];

return array(
   $registration
);

  }

  public function import(){

   $nodes =  \Drupal::entityTypeManager()->getStorage('node')
  ->loadByProperties(['type' => 'course', 'status' => 1]);


 $client = \Drupal::service('http_client_factory')->fromOptions([
      'base_uri' => 'http://3.7.173.255/athenadev/api/',
    ]);

    $response = $client->get('courselist');

    $courses = Json::decode($response->getBody());



  /*  $partenr_client = \Drupal::service('http_client_factory')->fromOptions([
      'base_uri' => 'http://3.7.173.255/athenadev/api/',
    ]);
    $partner_response = $partenr_client->get('courses/partners');
    $partners = Json::decode($partner_response->getBody());
    foreach($partners as $partner) {

        $partners_univ[$partner['cid']] =
       $partner['partner_universities_name']
        ;
    }

   $team_client = \Drupal::service('http_client_factory')->fromOptions([
      'base_uri' => 'http://3.7.173.255/athenadev/api/',
    ]);
    $teams_res = $team_client->get('courses/teams');
    $teams = Json::decode($teams_res->getBody());

    $team_course = array();
    foreach($teams as $team) {
       $team_course[$team['cid']] = $team['course_team_name'];
    }







     $bundle='course_team';
     $teamquery = \Drupal::entityQuery('node');
    $teamquery->condition('status', 1);
  //  $query->condition('field_course_academic_route', 'academic', 'CONTAINS');
    $teamquery->condition('type', $bundle);
    $team_ids = $teamquery->execute();
        $teamnodes = node_load_multiple($team_ids);
    foreach($teamnodes as  $team_data){
        $team_data_array[] = array(
          'nid' => $team_data->id(),
          'title' =>$team_data->get('title')->value
        );

    }

     $bundle='universities';
     $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
  //  $query->condition('field_course_academic_route', 'academic', 'CONTAINS');
    $query->condition('type', $bundle);
    $univ_ids = $query->execute();
        $univnodes = node_load_multiple($univ_ids);
    foreach($univnodes as  $univ_data){
        $univ_node_array[] = array(
          'nid' => $univ_data->id(),
          'title' =>$univ_data->get('title')->value
        );

    }

     //   print_r($univ_ids);exit;
      //  print_r($univ_node_array);exit;

*/

    $items = [];
    $node_ids = array();
     foreach($nodes as $node_key => $node) {
       $node_ids[] =  $node->get('field_cid')->value;
      }


     // print_r($courses);exit;
$i = 0;
    foreach ($courses as $key => $course_data) {
      $cid = $course_data['cid'];


$field_course_category = "Certifications";
      if($i>=0 && $i<=5)
      {
          $field_course_category = 'Academic';
      }elseif($i>5 && $i<9) {
          $field_course_category = 'Micro Credits';
      }

      $i++;
      $fee = 0;
      foreach($course_data['modular_fee'] as $module_data) {

         $fee = $fee+ $module_data['fee'];
      }

      if(empty($course_data['modular_fee'] )) {
          $fee = 600;
      }

      if(empty ($course_data['ects_credit'])) {

          $course_data['ects_credit'] = 18;
      }



     $eligibility =   Json::decode( $course_data['eligibility_requirements']);
        if(!in_array($cid, $node_ids)) {



          $new_node = Node::create(['type' => 'course']);
          $new_node->set('title',$course_data['course_name']);
         // $new_node->set('field_course_total_credits', $course_data['ects_credit']);
          $new_node->set('field_course_category', $field_course_category);
         // $new_node->set('field_course_awarding_body', $course_data['awarded_by']);
          //$new_node->set('field_course_overview', $course_data['course_introduction']);
        //  $new_node->set('field_course_total_fee', $fee);
          $new_node->set('field_course_academic_route',  $eligibility['academic_route']);
          $new_node->set('field_course_mature_entry_label', $eligibility['adult_entry_route']);
          $new_node->set('field_course_language_prof_label', $eligibility['language_proficiency']);
   //       $new_node->set('field_course_banner_description', "Be a business leader of tomorrow and advance your career with MBA Degree from Italy’s top B-School - Guglielmo Marconi University. Start your MBA journey today");
          //$new_node->set('field_course_duration', '9-36 months');
          $new_node->set('field_cid', $cid);
         // $new_node->save();
        } else {


          //  univ_node_array

        //    print_r($partners_univ);exit;
            // Attach Parteners.
      $what_you_get = array(
 1=>array(
"cid"=>1,
"what_you_get" =>array(
	1=>array(
		'course'=>'Master of International Business Administration',
		'univ'=>'Guglielmo Marconi University'),
	2=> array(
		'course'=>'Detailed Transcript with 60 ECTS Credits (IMBA)',
		'univ'=>'Guglielmo Marconi University',
		),
	3=>array(
		'course'=>'SCQF level 11 Extended Diploma in International Business and Strategy',
		'univ'=>'Scottish Qualifications Authority',
	),
	4=>array(
		'course'=>'Detailed Transcript with 120 SCQF Credits',
		'univ'=>'Scottish Qualifications Authority',
	),
	5=>array(
		'course'=>'Certified Manager Certification',
		'univ'=>'Chartered Management Institute',
	)

    )
),
 2=>array(
"cid"=>2,
"what_you_get" =>array(
	1=>array(
		'course'=>'SCQF Level 11 Extended Diploma in International Business & Strategy',
		'univ'=>'Scottish Qualifications Authority'),
	2=> array(
		'course'=>'Detailed Transcript with 120 SCQF Credits',
		'univ'=>'Scottish Qualifications Authority',
		),

    )
),


 4=>array(
"cid"=>4,
"what_you_get" =>array(
	1=>array(
		'course'=>'SCQF Level 11  Diploma in Supply Chain and Logistics Management',
		'univ'=>'Scottish Qualifications Authority'),
	2=> array(
		'course'=>'Detailed Transcript with 40 SCQF Credits',
		'univ'=>'Scottish Qualifications Authority',
		),

    )
),


 7=>array(
"cid"=>7,
"what_you_get" =>array(
	1=>array(
		'course'=>'Strategic Human Resource Management Practitioner - CMI',
		'univ'=>'Chartered Management Institute'),


    )
),


 9=>array(
"cid"=>9,
"what_you_get" =>array(
	1=>array(
		'course'=>'Postgraduate Certificate in Procurement & Contracts Management',
		'univ'=>'Cambridge International Qualifications'
		),
2=>array(
		'course'=>'Recordes of Achievments with Grade',
		'univ'=>'Cambridge International Qualifications'
		),

    )
),


 10=>array(
"cid"=>10,
"what_you_get" =>array(
	1=>array(
		'course'=>'SCQF Level 11 Diploma in International Business & Strategy',
		'univ'=>'Scottish Qualifications Authority'
		),
2=>array(
		'course'=>'Detailed Transcript with 60 SCQF Credits',
		'univ'=>'Scottish Qualifications Authority'
		),

    )
),


 13=>array(
"cid"=>13,
"what_you_get" =>array(
	1=>array(
		'course'=>'Master of Business Administration (MBA)',
		'univ'=>'Guglielmo Marconi University'
		),
2=>array(
		'course'=>'Detailed Transcript with 60 ECTS Credits (MBA)',
		'univ'=>'Guglielmo Marconi University'
		),

3=>array(
'course'=>'Certified Manager Certification',
'univ'=>'Chartered Management Institute'
),

    )
),


 15=>array(
"cid"=>15,
"what_you_get" =>array(
	1=>array(
		'course'=>'Postgraduate Certificate in International Marketing Management',
		'univ'=>'Cambridge International Qualifications'
		),
2=>array(
		'course'=>'Recordes of Achievments with Grade',
		'univ'=>'Cambridge International Qualifications'
		),



    )
),



 16=>array(
"cid"=>16,
"what_you_get" =>array(
	1=>array(
		'course'=>'Postgraduate Certificate In International Human Resource Management',
		'univ'=>'Cambridge International Qualifications'
		),
2=>array(
		'course'=>'Recordes of Achievments with Grade',
		'univ'=>'Cambridge International Qualifications'
		),



    )
),



 17=>array(
"cid"=>17,
"what_you_get" =>array(
	1=>array(
		'course'=>'Postgraduate Certificate in Business Sustainability',
		'univ'=>'Cambridge International Qualifications'
		),
2=>array(
		'course'=>'Recordes of Achievments with Grade',
		'univ'=>'Cambridge International Qualifications'
		),



    )
),


 18=>array(
"cid"=>18,
"what_you_get" =>array(
	1=>array(
		'course'=>'Postgraduate Certificate in Strategic Management',
		'univ'=>'Cambridge International Qualifications'
		),
2=>array(
		'course'=>'Recordes of Achievments with Grade',
		'univ'=>'Cambridge International Qualifications'
		),



    )
),


 19=>array(
"cid"=>19,
"what_you_get" =>array(
	1=>array(
		'course'=>'Executive MBA',
		'univ'=>'Universidad Catolica De Murcia (UCAM)'
		),
2=>array(
		'course'=>'Detailed Transcript with 60 ECTS Credits (EMBA)',
		'univ'=>'Universidad Catolica De Murcia (UCAM)'
		),
3=>array(
		'course'=>'Postgraduate Diploma In Organisational Leadership',
		'univ'=>'Cambridge International Qualifications'
		),
4=>array(
		'course'=>'Recordes of Achievments with Grade',
		'univ'=>'Cambridge International Qualifications'
		),
5=>array(
		'course'=>'Certified Manager Certification',
		'univ'=>'Chartered Management Institute'
		),

    )
),

 20=>array(
"cid"=>20,
"what_you_get" =>array(
	1=>array(
		'course'=>'Postgraduate Diploma in Procurement & Contracts Management',
		'univ'=>'Cambridge International Qualifications'
		),
2=>array(
		'course'=>'Recordes of Achievments with Grade',
		'univ'=>'Cambridge International Qualifications'
		),


    )
),


 22=>array(
"cid"=>22,
"what_you_get" =>array(
	1=>array(
		'course'=>'Certified Manager Certification',
		'univ'=>'Chartered Management Institute'
		),


    )
),


 25=>array(
"cid"=>25,
"what_you_get" =>array(
	1=>array(
		'course'=>'Executive MBA',
		'univ'=>'Universidad Catolica De Murcia (UCAM)'
		),
	2=>array(
		'course'=>'Detailed Transcript with 60 ECTS Credits (EMBA)',
		'univ'=>'Universidad Catolica De Murcia (UCAM)'
		),

			3=>array(
		'course'=>'Extended Diploma in Business Analytics',
		'univ'=>'Scottish Qualifications Authority'
		),

	4=>array(
		'course'=>'Detailed Transcript with 120 SCQF Credits',
		'univ'=>'Scottish Qualifications Authority'
		),


	5=>array(
		'course'=>'Certified Manager Certification',
		'univ'=>'Chartered Management Institute'
		),
    )
),



 26=>array(
"cid"=>26,
"what_you_get" =>array(
	1=>array(
		'course'=>'Project Management Practitioner Certification',
		'univ'=>'Chartered Management Institute'
		),
	)
),



 27=>array(
"cid"=>27,
"what_you_get" =>array(
	1=>array(
		'course'=>'Postgraduate Certificate in Strategic Supply Chain & Logistics Management',
		'univ'=>'Cambridge International Qualifications'
		),

	2=>array(
		'course'=>'Recordes of Achievments with Grade',
		'univ'=>'175|Cambridge International Qualifications'
		),
	)
),


 29=>array(
"cid"=>29,
"what_you_get" =>array(
	1=>array(
		'course'=>'Postgraduate Certificate in Strategic Supply Chain & Logistics Management',
		'univ'=>'Cambridge International Qualifications'
		),

	2=>array(
		'course'=>'Recordes of Achievments with Grade',
		'univ'=>'Cambridge International Qualifications'
		),
	)
),

 33=>array(
"cid"=>33,
"what_you_get" =>array(
	1=>array(
		'course'=>'Postgraduate Certificate in Business Analytics',
		'univ'=>'Cambridge International Qualifications'
		),

	2=>array(
		'course'=>'Recordes of Achievments with Grade',
		'univ'=>'Cambridge International Qualifications'
		),
	)
),

 34=>array(
"cid"=>34,
"what_you_get" =>array(
	1=>array(
		'course'=>'Postgraduate Certificate in HR & Leadership',
		'univ'=>'Cambridge International Qualifications'
		),

	2=>array(
		'course'=>'Recordes of Achievments with Grade',
		'univ'=>'Cambridge International Qualifications'
		),
	)
),


 35=>array(
"cid"=>35,
"what_you_get" =>array(
	1=>array(
		'course'=>'Postgraduate Certificate in Supply Chain Design & Implementation',
		'univ'=>'Cambridge International Qualifications'
		),

	2=>array(
		'course'=>'Recordes of Achievments with Grade',
		'univ'=>'Cambridge International Qualifications'
		),
	)
),


 36=>array(
"cid"=>36,
"what_you_get" =>array(
	1=>array(
		'course'=>'Postgraduate Certificate in Finance for Managers',
		'univ'=>'Cambridge International Qualifications'
		),

	2=>array(
		'course'=>'Recordes of Achievments with Grade',
		'univ'=>'Cambridge International Qualifications'
		),
	)
),


 39=>array(
"cid"=>39,
"what_you_get" =>array(
	1=>array(
		'course'=>'Supply Chain Management Practitioner Certificate',
		'univ'=>'Chartered Management Institute'
		),
	)

),








 );

            foreach($nodes as $node_key => $oldnode) {



               if($oldnode->get('field_cid')->value == $cid) {

$fact_data = array();
$fact_data[1] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_IMBA_Ver0420_01.pdf',
'broucher' => 'https://athena.edu/Uploads/Courses/IMBA_BROCHURE_AGE.pdf',
'spec' => ''
);
$fact_data[2] = array(
'fact_sheet' => '',
'broucher' => 'https://athena.edu/Uploads/Courses/Fact_sheet_EDIBS_Ver0420_01.pdf',
'spec' => ''
);
$fact_data[4] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_DSCLM_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);
$fact_data[7] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_CMI_SHRMP_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);
$fact_data[9] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_CIQ_PGCPCM_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);
$fact_data[10] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_DIBS_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);
$fact_data[13] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_MBA_Ver0420_01.pdf',
'broucher' => 'https://athena.edu/Uploads/Courses/GmuMBA-brochure.pdf',
'spec' => 'https://athena.edu/Uploads/Courses/GMUMBA-Course-Sepcification.pdf'
);
$fact_data[15] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_CIQ_PGCIMM_Ver0420_01.pdf',
'broucher' => 'https://athena.edu/Uploads/Courses/pgcimm-ciq-brochure.pdf',
'spec' => ''
);
$fact_data[16] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_CIQ_PGCIHRM_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);
$fact_data[17] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_CIQ_PGCBS_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);
$fact_data[18] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_CIQ_PGCSM_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);
$fact_data[19] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_DIBS_Ver0420_01.pdf',
'broucher' => 'https://athena.edu/Uploads/Courses/UCAM-BROCHURE-AGE-2.pdf',
'spec' => 'https://athena.edu/Uploads/Courses/EMBA_UCAM_SPECIFICATIONS_PDF.pdf'
);
$fact_data[20] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_CIQ_PGDPCM_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);
$fact_data[22] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_CMI_CM_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);
$fact_data[25] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_EMBA_Business_Analytics_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);$fact_data[26] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_CMI_PMP_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);$fact_data[27] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_CIQ_PGCSSCLM_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);
$fact_data[29] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_EDBA_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);

$fact_data[32] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_UCAM_DBA_Ver0820_01.pdf',
'broucher' => 'https://athena.edu/Uploads/Courses/DBA_Brochure.pdf',
'spec' => ''
);

$fact_data[33] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_CIQ_PGCBA_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);
$fact_data[34] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_CIQ_PGCHRL_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);
$fact_data[35] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_CIQ_PGCSCDI_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);
$fact_data[36] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_CIQ_PGFNGM_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);
$fact_data[39] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_CIQ_PGSCMP_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);

$fact_data[40] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_CIQ_PGCSELF_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);

$fact_data[41] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_CIQ_PGCMCF_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);

$fact_data[42] = array(
'fact_sheet' => 'https://athena.edu/Uploads/Courses/Fact_sheet_FT_MBAGM_Ver0420_01.pdf',
'broucher' => '',
'spec' => ''
);




 $oldnode->set('field_fact_sheet',$fact_data[$cid]['fact_sheet']);
 $oldnode->set('field_brochure',$fact_data[$cid]['broucher']);
 $oldnode->set('field_specifications',$fact_data[$cid]['spec']);
                $oldnode->save();

               /*
                   //print $oldnode->id();exit;
                  if (!empty($what_you_get[$cid]['what_you_get'])) {
                  // print_r($what_you_get[$cid]);exit;
                   $what_dd = array();
                   foreach($what_you_get[$cid]['what_you_get'] as  $what_data){
                       $paragraph = Paragraph::create(['type' => 'what_you_get']);
                  $paragraph->set('field_degree', $what_data['course']);
                  $paragraph->set('field_issued_by', $what_data['univ']);
                  $paragraph->save();
                   $what_dd[] = array(
                      'target_id' => $paragraph->id(),
                      'target_revision_id' => $paragraph->getRevisionId(),
                    );

                   }
                   $oldnode->set('field_what_you_get',$what_dd);
                $oldnode->save();
                  }


              if(!empty($partners_univ[$oldnode->get('field_cid')->value])) {
               // $oldnode->field_link_universities->entity = Node::load(209);;

               $univ_dd = array();
               foreach($partners_univ[$oldnode->get('field_cid')->value] as $course_unive_linked_data) {

               // $univ_node_array
                 foreach($univ_node_array as $map_univ) {
                     if(strtolower($map_univ['title']) == strtolower($course_unive_linked_data)) {
                           $paragraph = Paragraph::create(['type' => 'unversities_linked_to_content']);
                  $paragraph->set('field_university', $map_univ['nid']);
                  $paragraph->save();
                   $univ_dd[] = array(
                      'target_id' => $paragraph->id(),
                      'target_revision_id' => $paragraph->getRevisionId(),
                    );
                         break;
                     }
                 }
                 }


                 $oldnode->set('field_link_universities',$univ_dd);
                $oldnode->save();

            }

             $oldnode->set('field_link_universities',$univ_dd);
                $oldnode->save();


            if(!empty($team_course[$oldnode->get('field_cid')->value])) {
               // $oldnode->field_link_universities->entity = Node::load(209);;

               $team_nid_array = array();
               foreach($team_course[$oldnode->get('field_cid')->value] as $team_linked_data) {

               // $univ_node_array
                 foreach($team_data_array as $map_course_univ) {
                     if(strtolower($team_linked_data) == strtolower($map_course_univ['title'])) {
                        $team_nid_array[] = $map_course_univ['nid'];


                    //
                         break;
                     }
                 }
                 }

                 $oldnode->set('field_course_team_member',$team_nid_array);
                $oldnode->save();


            }

            if($cid == 7) {

                //print $oldnode->id();exit;
            }
            */

               }
            }





            /*
               foreach($nodes as $node_key => $oldnode) {
                if($oldnode->get('field_cid')->value == $cid) {
          //$oldnode->set('title',$course_data['course_name']);
          //$oldnode->set('field_course_total_credits', $course_data['ects_credit']);
          //$oldnode->set('field_course_awarding_body', $course_data['awarded_by']);
          //$oldnode->set('field_course_overview', $course_data['course_introduction']);
          //$oldnode->set('field_course_total_fee', $fee);
       //   $oldnode->set('field_course_category', $field_course_category);
          $oldnode->set('field_course_academic_route',  $eligibility['academic_route']);
          $oldnode->set('field_course_mature_entry_label', $eligibility['adult_entry_route']);
          $oldnode->set('field_course_language_prof_label', $eligibility['language_proficiency']);
            //$oldnode->set('field_course_duration', '9-36 months');
//$oldnode->set('field_course_banner_description', "Be a business leader of tomorrow and advance your career with MBA Degree from Italy’s top B-School - Guglielmo Marconi University. Start your MBA journey today");
            $current = array();

            if(empty ($course_data['modular_fee'])) {

                $course_data['modular_fee'][]  = array('fee' => 200, 'module_name'=>'module 1');
                $course_data['modular_fee'][]  = array('fee' => 200, 'module_name'=>'module 2');
                $course_data['modular_fee'][]  = array('fee' => 200, 'module_name'=>'module 3');
            }

            $module_fee_array=array();
            foreach($course_data['modular_fee'] as $module_data) {
                $fee = $fee+ $module_data['fee'];
                $paragraph = Paragraph::create(['type' => 'course_module_details']);
                  $paragraph->set('field_course_module_fees', $module_data['fee']);
                  $paragraph->set('field_coursemodule_description', $module_data['module_desc']);
                  $paragraph->set('field_module_level', $module_data['module_level']);
                  $paragraph->set('field_module_credit', $module_data['module_credits']);
                //  $paragraph->enforceIsNew();
                  $paragraph->set('field_course_module_name', $module_data['fk_module_name']);
                  $paragraph->save();
                   $module_fee_array[] = array(
                      'target_id' => $paragraph->id(),
                      'target_revision_id' => $paragraph->getRevisionId(),
                    );
            }

            $oldnode->field_course_modules->setValue(array());
             $oldnode->save();
                $oldnode->set('field_course_modules', $module_fee_array);

            // $feecurrent = $oldnode->get('field_course_module_fees')->getValue();
            $feecurrent=array();
            foreach($course_data['fee_details'] as $module_fee_data) {
                $feeparagraph = Paragraph::create(['type' => 'course_fee_details']);
                  $feeparagraph->set('field_fee_label', $module_fee_data['fk_fee_detail']);
                  $feeparagraph->set('field_paragraphh_module_fees', $module_fee_data['fee']);
              //   $feeparagraph->enforceIsNew();
                // enforceIsNew();
                  $feeparagraph->save();
                   $feecurrent[] = array(
      'target_id' => $feeparagraph->id(),
      'target_revision_id' => $feeparagraph->getRevisionId(),
    );
            }
            $oldnode->field_course_module_fees->setValue(array());
            $oldnode->save();

            $oldnode->set('field_course_module_fees', $feecurrent);


            $course_faq = array();
             foreach($course_data['faqs'] as $faq_data) {
                $paragraph_course_team = Paragraph::create(['type' => 'faq']);
                  $paragraph_course_team->set('field_question', $faq_data['question']);
                  $paragraph_course_team->set('field_answer', $faq_data['answer']);
                  $paragraph_course_team->set('field_category', 'About_the_Course');
                  //$paragraph_course_team->enforceIsNew();
                  $paragraph_course_team->save();
                   $course_faq[] = array(
      'target_id' => $paragraph_course_team->id(),
      'target_revision_id' => $paragraph_course_team->getRevisionId(),
    );
            }
             $oldnode->field_faq->setValue(array());
             $oldnode->save();
                $oldnode->set('field_faq', $course_faq);





            $oldnode->save();
                   //     break;

                        }
                }*/



       }
    }

return array(
  '#markup' => '<h2>Course data updated from API</h2>',
);

  }


function search($word = false){

    $word = strip_tags($word);
    $word = trim($word);

    if ($word != 'abc') {
      $_POST['search_key'] = $word;
    }

    if(isset($_POST['search_key']) && strpos(strtolower($_POST['search_key']), 'certification') !== false){
       $_POST['search_key'] = 'certificate';
    }

    $bundle='course';
    $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);

    $grp = $query->orConditionGroup()
      ->condition('title' ,$_POST['search_key'] ,'CONTAINS')
      ->condition('field_course_banner_description.value' ,$_POST['search_key'] , 'CONTAINS');

    // Filter conditions
    if(isset ($_REQUEST['lang']) && !empty($_REQUEST['lang']) && $_REQUEST['lang'] != 'language') {
        $query->condition('field_course_language_prof_label.value' ,$_REQUEST['lang'] , 'CONTAINS');
    }

    if(isset ($_REQUEST['duration']) && !empty($_REQUEST['duration']) && $_REQUEST['duration'] != 'duration') {
        $query->condition('field_course_duration.value', $_REQUEST['duration'], 'CONTAINS');
    }


    if(isset ($_POST['course_category'])) {
      $query->condition('field_course_category', $_POST['course_category']);
    }
    $query->condition('type', $bundle);

    // $entity_ids = $query->execute();
    $entity_ids = $query->condition($grp)->execute();

    $partners = array(
      'Scottish Qualifications Authority, UK',
      'Guglielmo Marconi University, Italy',
      'Cambridge International Qualifications, UK',
      'Universidad Catolica De Murcia (UCAM), Spain',
      'Chartered Management Institute, UK',
    );

    $partner_list = '';
    foreach($partners as $partner) {
      if(isset($_REQUEST['univ']) && $_REQUEST['univ'] == $partner) {
         $partner_list .=  '<option value="'.$partner.'" selected>'.$partner.'</option>';
      }else {
          $partner_list .=  '<option value="'.$partner.'">'.$partner.'</option>';
      }
    }

    // Base theme path.
    global $base_url;
    $theme = \Drupal::theme()->getActiveTheme();

    if(!empty($entity_ids)) {
      $nodes = node_load_multiple($entity_ids);
    }

    $merged_nodes =  $nodes ;


    $term_name = $_POST['search_key'];
    if (!empty($term_name)) {
      $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')
        ->loadByProperties(['name' => $term_name, 'vid' => 'tags']);
      if (count($term) > 0) {
        $term = reset($term);
        $term_id = $term->id();
        $term_node = \Drupal::entityTypeManager()->getStorage('node')->getQuery()
        ->latestRevision()
        ->condition('field_tagtaxanomy', $term_id, '=')
        ->condition('type', $bundle)
        ->execute();

        $tnodes = node_load_multiple($term_node);
        $merged_nodes = array_merge($nodes, $tnodes);

      }
    }


    // if(strpos(strtolower($_POST['search_key']), 'diploma') !== false){
    //   $term_node = \Drupal::entityTypeManager()->getStorage('node')->getQuery()
    //   ->latestRevision()
    //   ->condition('field_tagtaxanomy', 9, '=')
    //   ->condition('type', $bundle)
    //   ->execute();

    //   $tnodes = node_load_multiple($term_node);
    //   $merged_nodes = array_merge($nodes, $tnodes);

    // }

    // if(strpos(strtolower($_POST['search_key']), 'degree') !== false){
    //   $term_node = \Drupal::entityTypeManager()->getStorage('node')->getQuery()
    //   ->latestRevision()
    //   ->condition('field_tagtaxanomy', 10, '=')
    //   ->condition('type', $bundle)
    //   ->execute();

    //   $tnodes = node_load_multiple($term_node);
    //   $merged_nodes = array_merge($nodes, $tnodes);

    // }

    // if(strpos(strtolower($_POST['search_key']), 'certification') !== false){
    //   $term_node = \Drupal::entityTypeManager()->getStorage('node')->getQuery()
    //   ->latestRevision()
    //   ->condition('field_tagtaxanomy',11, '=')
    //   ->condition('type', $bundle)
    //   ->execute();

    //   $tnodes = node_load_multiple($term_node);
    //   $merged_nodes = array_merge($nodes, $tnodes);
    // }


    if (isset($_REQUEST['univ']) && !empty($_REQUEST['univ']) && $_REQUEST['univ'] != 'partner') {
      $universityContentType = 'universities';
      $universityQuery = \Drupal::entityQuery('node');
      $universityQuery->condition('status', 1);
      $universityQuery->condition('title', $_REQUEST['univ']);
      $universityQuery->condition('type', 'universities');
      $universityData = $universityQuery->execute();
      if (count($universityData) > 0) {
        $univNid = reset($universityData);
        foreach ($merged_nodes as $key => $node) {
          $mergedNodeNid = $node->id();
          $universitiesPara =  $node->field_link_universities->referencedEntities();
          foreach($universitiesPara as $key2 => $univPara) {
            $universities[$mergedNodeNid][] = $univPara->field_university->value;
          }
          if (!in_array($univNid, $universities[$mergedNodeNid])) {
            unset($merged_nodes[$key]);
          }
        }
      }

    }


  foreach ($merged_nodes as $key => $node) {
    $mergedNodeNids[] = $node->id();
  }
  $filterNodes = array_filter($mergedNodeNids);
  foreach ($variable as $key => $nodeNid) {
    $merged_nodes[] = Node::load($nodeNid);
  }

  $base_path = $base_url.'/'. $theme->getPath();
    $banner_block =  [
    '#theme' => 'course_search',
   '#base_path' => $base_path,
   '#node' => $merged_nodes,
   '#partner_list' => $partner_list,
   '#search_key' => $_POST['search_key'],
   '#count' => count($merged_nodes)

  ];

  return array(
   $banner_block
  );
}


function academic(){
 // Base theme path.
global $base_url;
$theme = \Drupal::theme()->getActiveTheme();
$base_path = $base_url.'/'. $theme->getPath();


$alias = \Drupal::service('path.alias_manager')->getPathByAlias('/explore-courses');
$params = Url::fromUri("internal:" . $alias)->getRouteParameters();
$entity_type = key($params);
$node = \Drupal::entityTypeManager()->getStorage($entity_type)->load($params[$entity_type]);

$paragraph_data = $node->field_explore_course_details->referencedEntities();


foreach($paragraph_data as $explore_data) {

    $type = $explore_data->get('field_explore_course_type')->value;

    if($type == 'Academic') {
        $title1 = 'Academic';
        $title2 = 'Programs';
        $desc = $explore_data->get('field_explore_course_banner_desc')->value;
        $header_image = $explore_data->get('field_header_background_image')->value;
        $header_image = $explore_data->get('field_header_background_image')->entity->getFileUri();
        $url = file_create_url($header_image);
        break;
    }

}


// Course list
  $bundle='course';
     $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
  //  $query->condition('field_course_academic_route', 'academic', 'CONTAINS');
$query->condition('field_course_category', 'Academic');
    $query->condition('type', $bundle);
    $academic_list = $query->execute();

   $academicnodes = node_load_multiple($academic_list);
//$academicnodes =  array_slice($academicnodes, 0, 3);

 $bundle='insight_article';

    $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
    $query->condition('type', $bundle);
    $query->sort('created' , 'DESC');
    $latest = $query->execute();


    $insightsnodes = node_load_multiple($latest);

    $latest_insights =  array_slice($insightsnodes, 0, 5);
$academic =  [
  '#theme' => 'course_academic',
  '#title1' => $title1,
  '#title2' => $title2,
  '#insig' => $latest_insights,
  '#desc' => $desc,
  '#header_image' => $url,
  '#paragraph' => $type,
  '#course_list' => $academicnodes,
  '#base_path' => $base_path,
];


return array($academic);


}


function micro_credits(){
 // Base theme path.
global $base_url;
$theme = \Drupal::theme()->getActiveTheme();
$base_path = $base_url.'/'. $theme->getPath();


$alias = \Drupal::service('path.alias_manager')->getPathByAlias('/explore-courses');
$params = Url::fromUri("internal:" . $alias)->getRouteParameters();
$entity_type = key($params);
$node = \Drupal::entityTypeManager()->getStorage($entity_type)->load($params[$entity_type]);

$paragraph_data = $node->field_explore_course_details->referencedEntities();


foreach($paragraph_data as $explore_data) {

    $type = $explore_data->get('field_explore_course_type')->value;

    if($type == 'Micro Credits') {
        $title1 = 'Micro';
        $title2 = 'Credits';
        $desc = $explore_data->get('field_explore_course_banner_desc')->value;
        $header_image = $explore_data->get('field_header_background_image')->value;
        $header_image = $explore_data->get('field_header_background_image')->entity->getFileUri();
        $url = file_create_url($header_image);
        break;
    }

}


// Course list
  $bundle='course';
     $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
  //  $query->condition('field_course_academic_route', 'academic', 'CONTAINS');
$query->condition('field_course_category', 'Micro Credits');
    $query->condition('type', $bundle);
    $academic_list = $query->execute();

   $academicnodes = node_load_multiple($academic_list);
   //$academicnodes =  array_slice($academicnodes, 0, 3);

$academic =  [
  '#theme' => 'course_academic',
  '#title1' => $title1,
  '#title2' => $title2,
  '#desc' => $desc,
  '#header_image' => $url,
  '#paragraph' => $type,
  '#course_list' => $academicnodes,
  '#base_path' => $base_path,
];


return array($academic);


}


function certifications(){
 // Base theme path.
global $base_url;
$theme = \Drupal::theme()->getActiveTheme();
$base_path = $base_url.'/'. $theme->getPath();


$alias = \Drupal::service('path.alias_manager')->getPathByAlias('/explore-courses');
$params = Url::fromUri("internal:" . $alias)->getRouteParameters();
$entity_type = key($params);
$node = \Drupal::entityTypeManager()->getStorage($entity_type)->load($params[$entity_type]);

$paragraph_data = $node->field_explore_course_details->referencedEntities();


foreach($paragraph_data as $explore_data) {

    $type = $explore_data->get('field_explore_course_type')->value;

    if($type == 'Certifications') {
        $title1 = 'Certifications';

        $desc = $explore_data->get('field_explore_course_banner_desc')->value;
        $header_image = $explore_data->get('field_header_background_image')->value;
        $header_image = $explore_data->get('field_header_background_image')->entity->getFileUri();
        $url = file_create_url($header_image);
        break;
    }

}


// Course list
  $bundle='course';
     $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
  //  $query->condition('field_course_academic_route', 'academic', 'CONTAINS');
$query->condition('field_course_category', 'Certifications');
    $query->condition('type', $bundle);
    $academic_list = $query->execute();

   $academicnodes = node_load_multiple($academic_list);
   //$academicnodes =  array_slice($academicnodes, 0, 3);

   $bundle='insight_article';

    $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
    $query->condition('type', $bundle);
    $latest = $query->execute();


    $insightsnodes = node_load_multiple($latest);

    $latest_insights =  array_slice($insightsnodes, 0, 5);

$academic =  [
  '#theme' => 'course_academic',
  '#title1' => $title1,
  '#title2' => $title2,
  '#insig' => $latest_insights,
  '#desc' => $desc,
  '#header_image' => $url,
  '#paragraph' => $type,
  '#course_list' => $academicnodes,
  '#base_path' => $base_path,
];


return array($academic);


}

public function university(){
global $base_url;
$theme = \Drupal::theme()->getActiveTheme();
$base_path = $base_url.'/'. $theme->getPath();

$data = array();
$univ = $_REQUEST['univ'];
 $bundle='universities';
     $query = \Drupal::entityQuery('node');
    //$query->condition('status', 1);
  //  $query->condition('field_course_academic_route', 'academic', 'CONTAINS');
$query->condition('field_university_key', strtolower($univ), '=');
    $query->condition('type', $bundle);
    $universities = $query->execute();
    
$universities = node_load_multiple($universities);
$node = current($universities);
$banner = $node->get('field_university_key')->value.'-banner';
$enable_card = '';
switch($univ) {
case 'ucam':
$banner = 'Ucam-banner';
$enable_card  = TRUE;
$data = array(
'enable_card' => TRUE,
);
break;

case 'gmu':
$data = array(

);

break;

case 'sqa':
$data = array(
);

break;

case 'ciq':
$data = array(
);

break;

case 'cmi':
$data = array(
);

break;


}

$data_array = array(
'banner_desc' =>$node->get('field_university_banner_descript')->value,
'rank' =>$node->get('field_rankings')->value,
'video_link' =>$node->get('field_video_link')->value,
'enable_card' =>$enable_card,
'accred' =>$node->get('field_accrediation_and_membershi')->value,
'univ_banner' =>$banner,
'about' =>$node->get('field_about_us')->value,
);
$academic =  [
  '#theme' => 'university',
  '#title1' => $title1,
  '#data' => $node,
  '#univ_data' => $data_array,
  '#base_path' => $base_path,
];


return array($academic);

}

public function smo_list(){
    $nodes =  \Drupal::entityTypeManager()->getStorage('node')
  ->loadByProperties(['type' => 'course', 'status' => 1]);

$node_ids = array();
     foreach($nodes as $node_key => $node) {
       $node_ids[] =
       array(
       "nid"=>$node->id(),
       "title"=>$node->label()

       );
      }

//print_r($node_ids);exit;

$academic =  [
  '#theme' => 'courselist',
  '#nodeid' => $node_ids,
  '#base_path' => $base_path,
];


return array($academic      );



}


}
