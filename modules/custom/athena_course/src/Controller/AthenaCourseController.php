<?php
namespace Drupal\athena_course\Controller;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\Component\Serialization\Json;

use \Drupal\Core\Url;

class AthenaCourseController {

public function news_subscription(){

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
   //     $certificates = $explore_data->get('field_certificate')[1]->entity->getFileUri();
     //  print  $url = file_create_url($certificates);exit;
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



    $banner_block =  [
      '#theme' => 'smo',
      '#course_title' => $node->get('title')->value,
      '#ects_credit' => $node->get('field_course_ects_credit')->value,
      '#awarding_body' => $node->get('field_course_awarding_body')->value,
      '#description' => $node->get('field_course_banner_description')->value,
      '#category' => $node->get('field_course_category')->value,
      '#banner' => $node->get('field_course_banner_image')->entity->uri->value,
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
     $recortimage = file_create_url($recortimage);
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




//print_r($node);exit;
$registration =  [
  '#theme' => 'course_registration',
  '#base_path' => $base_path,
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



    $partenr_client = \Drupal::service('http_client_factory')->fromOptions([
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
          $new_node->save();
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


               /*
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



   /* $nodes =  \Drupal::entityTypeManager()->getStorage('node')
  ->loadByProperties(['type' => 'course', 'status' => 1]);*/
   if(isset($_POST['search_key']) && strpos(strtolower($_POST['search_key']), 'certification') !== false){
       $_POST['search_key'] = 'certificate';
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


    if(strpos(strtolower($_POST['search_key']), 'diploma') !== false){
    $term_node = \Drupal::entityTypeManager()->getStorage('node')->getQuery()
->latestRevision()
->condition('field_tagtaxanomy', 9, '=')
->condition('type', $bundle)
->execute();

    $tnodes = node_load_multiple($term_node);
$merged_nodes = array_merge($nodes, $tnodes);

    }
if(strpos(strtolower($_POST['search_key']), 'degree') !== false){
    $term_node = \Drupal::entityTypeManager()->getStorage('node')->getQuery()
->latestRevision()
->condition('field_tagtaxanomy', 10, '=')
->condition('type', $bundle)
->execute();

    $tnodes = node_load_multiple($term_node);
$merged_nodes = array_merge($nodes, $tnodes);

    }
    
    if(strpos(strtolower($_POST['search_key']), 'certification') !== false){
    $term_node = \Drupal::entityTypeManager()->getStorage('node')->getQuery()
->latestRevision()
->condition('field_tagtaxanomy',11, '=')
->condition('type', $bundle)
->execute();

    $tnodes = node_load_multiple($term_node);
$merged_nodes = array_merge($nodes, $tnodes);

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

  return array(
  '#markup' => '<h2>COooll</h2>',
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

$univ = $_REQUEST['univ'];

$data = array();

switch($univ) {
case 'ucam':

$data = array(
'univ_label' => $univ,
'enable_card' => TRUE,
'univ_banner' => 'Ucam-banner',
'title' => 'Universidad Católica de Murcia, Spain',
'about' => "Universidad Católica De Murcia (UCAM) is a university par excellence based out of Murcia, Spain. Established in 1996, UCAM has an active student base of 17,0000 learners and an academic staff of more than 1000. The university is accredited by the Ministry of Education, Spain and National Agency for Quality Assessment and Accreditation of Spain (ANECA). UCAM is a member of The European Association for Quality Assurance in Higher Education (ENQA), Universia and European University association (EUA). It has a strategic partnership network with more than 280 universities including UC Berkeley, Stanford, Università di Bologna, National University of Singapore and Nanyang Technological University. UCAM centres in Cuba, Jakarta, Singapore, and Brussels work together to further develop the university’s international strategy.
UCAM is strongly linked to the business world through study plans responsive to market exigencies, obligatory internships in public and private institutions and enterprises as part of every undergraduate and master's degree, as well as research programs in collaboration with large regional, national and multinational companies.The university has corporate strategic partnership with industry leaders like Coca Cola, DANONE, Vodafone and Siemens including Microsoft, and SAP.
UCAM is also known as the University of Sports. It is the only European university with a professional basketball team in the first national league (ACB League Spain) and counts more than 80 Olympiads as its alumni.
",
'acc' => "UCAM is accredited by ANECA (National Agency for Quality Assessment and Accreditation of Spain) as well as by the Ministry of Education, Spain with regards to 17 of its undergraduate degrees.
UCAM is a member of The European Association for Quality Assurance in Higher Education (ENQA), Universia and European University association (EUA).
",
"rank" => "The Europe Teaching Rankings is published by Times Higher Education (THE), which is one of the three most important ranking organisations of the world, together with the QS and the Shanghai ranking. UCAM is ranked among the 200 best universities in Europe and the 10 best  valued by its students by The Times Higher Education World University Rankings 2021.
UCAM has obtained the tenth place in four large areas of study, which assesses the satisfaction of the services provided, the quality of teaching and the general assessment of the institution by the student. In the list, the Spanish university education stands out as the second best assessed one, behind the UK, with 14 universities among the first 100 positions.
",
'desc' => "Universidad Católica De Murcia (UCAM) is a university par excellence based out of Murcia, Spain. Established in 1996, the university is accredited by the Ministry of Education, Spain, ANECA and is a member of ENQA, Universia and EUA. UCAM is ranked among the 200 best universities in Europe and the 10 best  valued by its students by The Times Higher Education World University Rankings 2021. UCAM has a strategic partnership network with more than 280 universities."
);
break;

case 'gmu':
$data = array(
'univ_label' => $univ,
'univ_banner' => 'gmu-banner',
'title' => 'Guglielmo Marconi University (GMU)',
'about' => "
Guglielmo Marconi University (GMU) is based in Rome, Italy and  it is the first Italian Open University recognized by the Italian Ministry of Education, University and Research (MIUR) Presently, GMU has a community of over 16.000 students enrolled in graduate and postgraduate programs, a team of 300 faculty members and academic advisors and more than 200 tutoring experts. It appears among the 25 top performers worldwide in the categories of the U-Multirank ranking system for open access publications, international joint publications and regional joint publications.
GMU is a world-class Italian university offering a wide range of lectures, workshops, and research ventures, promoting innovative learning methodologies, exploring the use of technological advancements in education, providing interdisciplinary knowledge, skills and competences, with a particular focus on global perspectives, contemporary culture and Industry.
GMU distinguishes itself by the operational blended format that combines traditional learning with advanced technological solutions, offering distance learning methodologies (online classes, virtual labs and simulations) and interpersonal training activities (lectures, seminars, laboratories, review and in-depth sessions). This format provides students a valuable experience both online and offline, by preserving face-to-face interactions with professors, seminars and lessons within the athenaeum, and by granting access to intranet and institutional resources.
Since 1999, Italian Universities abided to the ‘Bologna Process’, launched with the Bologna Declaration of 1999 and defined by the European Higher Education Area (EHEA).In relation to this reform, the university system is organized in 3 cycles: Bachelor Degree, Master degree and Doctorates in all different schools.

",
'acc' => "GMU is the first online university accredited to the Italian Ministry of Education (MIUR). It has been accredited since 2010 to the Hellenic National Center for Information and Academic Recognition (DOATAP) and offers degrees in modern languages ​​and literature, psychology and education sciences, as well as a master's degree in leadership, management and technologies of education.
Guglielmo Marconi University has collaboration agreements with European, American, African, Middle Eastern, Central and South American institutions. These agreements mainly foresee transactional mobility, generate bilateral and multilateral partnerships, develop activities and study programs among institutions that release dual or joint degrees, promote and diffuse the Italian language and culture, ultimately enhancing the quality of academic systems.

",
"rank" => "GMU appears among the 25 top performers worldwide in the categories of the U-Multirank ranking system for open access publications, international joint publications and regional joint publications.

",
'desc' => ""
);

break;

case 'sqa':
$data = array(
'univ_label' => $univ,
'univ_banner' => 'sqa-banner',
'title' => 'Scottish Qualifications Authority (SQA)',
'about' => "
Scottish Qualifications Authority (SQA) is the executive public body of Scottish government responsible for accrediting educational awards and is accredited by the UK government to offer educational qualifications. Being one of the four partner national organisations in the Curriculum for Excellence, SQA designs and develops new qualifications and assessments, validates qualifications and reviews them to ensure they are up to date.  It has created the Scottish Credit and Qualifications Framework (SCQF).
The SCQF supports lifelong learning and can help:
People of all ages and circumstances to access appropriate education and training over their lifetime, so as to fulfil their personal, social and economic potential
Employers, learners and the general public to understand the full range of Scottish qualifications, how qualifications relate to each other and to other forms of learning, and how different types of qualification can contribute to improving the skills of the workforce.
The SCQF helps describe both programmes of learning and qualifications, support the development of progression routes and maximise the opportunities to transfer credit points between qualifications to ensure that a learner does not have to repeat any learning they have already undertaken. The SCQF also helps to illustrate the relationships between Scottish qualifications and those in the rest of the UK, Europe and beyond, which can clarify opportunities for international progression routes and credit transfer.

",
'acc' => "GMU is the first online university accredited to the Italian Ministry of Education (MIUR). It has been accredited since 2010 to the Hellenic National Center for Information and Academic Recognition (DOATAP) and offers degrees in modern languages ​​and literature, psychology and education sciences, as well as a master's degree in leadership, management and technologies of education.
Guglielmo Marconi University has collaboration agreements with European, American, African, Middle Eastern, Central and South American institutions. These agreements mainly foresee transactional mobility, generate bilateral and multilateral partnerships, develop activities and study programs among institutions that release dual or joint degrees, promote and diffuse the Italian language and culture, ultimately enhancing the quality of academic systems.

",
"rank" => '',
'desc' => ''
);

break;

case 'ciq':
$data = array(
'univ_label' => $univ,
'univ_banner' => 'ciq-banner',
'title' => 'Cambridge International Qualifications (CIQ), UK',
'about' => "
Cambridge International Qualifications (CIQ), UK is a professional awarding body based in the United Kingdom and its subsidiary of Westford Education Group which is in higher education since 2009. CIQ is founded on the vision of helping individual learners and employers in attaining quality accredited awards. With centres across the Middle East, Europe and African region, CIQ is a proud certification partner for more than 100 organizations and has a progression pathway with some of the leading universities across the world.
CIQ offers credit rated programmes under Scottish Credit Qualification Framework (SCQF) through the credit rating agency Scottish Qualification Authority which enables the student to attain UK regulated qualifications. Apart from the credit rated programmes, CIQ also offers stand-alone professional diploma and certification programmes which have been developed based on the current need of the industry. CIQ also partnered with NCFE-UK (Northern Council for Further Education) and TQUK (Training Qualifications, UK) for joint certification for the courses developed by CIQ.
 CIQ has gained a reputation for the high-quality support services provided to the education sector. CIQ works with schools, colleges, universities, and corporate bodies as well as Government agencies to provide relevant, effective, and flexible programmes. Its qualification and assessment framework is up-to-date, result oriented and meets the defined values as per international standards. CIQ qualifications are approved for progression to higher qualifications offered by international universities around the globe.
The CIQ qualification and assessment framework have been developed in consultation with leaders from various corporate bodies, government agencies, and universities around the world. CIQ programmes are frequently assessed to enhance quality and ensure they are relevant for the rapidly changing global market as well as career opportunities for ambitious individuals. The CIQ Qualification and assessment framework is available throughout the world and may be accessed via their “Approved Centre Network”.

",
'acc' => '',
"rank" => '',
'desc' =>''
);

break;

case 'cmi':
$data = array(
'univ_label' => $univ,
'univ_banner' => 'cmi-banner',
'title' => 'Chartered Management Institute (CMI), UK',
'about' => "
Chartered Management Institute, backed by Royal Charter, is the only Chartered body dedicated to promoting the highest standards in management and leadership excellence. CMI’s management qualifications are recognized throughout the UK and Europe and provide a progressive framework that enables one to develop and broaden management skills. Their qualifications are designed in consultation with employers to meet today's demands and therefore they are valued by them.
Their certification is flexible. One can study locally via their 600+ approved centres or through a Distance Learning Provider. Their resources are designed specifically for the qualification to ensure that the student has the correct support and free access to all key membership services for the duration of his study.
Practical help whenever you need it; tools and techniques to save time and stress; new ways to enhance your professional reputation; qualifications that show the world you mean business – that’s what CMI is all about.

",
'acc' => '',
"rank" => '',
'desc' => ''
);

break;


}

$academic =  [
  '#theme' => 'university',
  '#title1' => $title1,
  '#data' => $data,
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
