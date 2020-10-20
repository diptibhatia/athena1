<?php
namespace Drupal\athena_course\Controller;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph; 
use Drupal\Component\Serialization\Json;

use \Drupal\Core\Url;

class AthenaCourseController {
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
$banner_block =  [
  '#theme' => 'course_banner',
  '#course_title' => $node->get('title')->value,
  '#ects_credit' => $node->get('field_course_ects_credit')->value,
  '#awarding_body' => $node->get('field_course_awarding_body')->value,
  '#description' => $node->get('field_course_banner_description')->value,
  '#category' => $node->get('field_course_category')->value,
  '#banner' => $node->get('field_course_banner_image')->entity->uri->value,
  '#base_path' => $base_path,
  '#node' => $node
]; 

$paragraph_univ_data = $node->field_link_universities->referencedEntities();


foreach($paragraph_univ_data as $explore_data) {
    
        $university_nid = $explore_data->get('field_university')->value;
   //     $certificates = $explore_data->get('field_certificate')[1]->entity->getFileUri();
     //  print  $url = file_create_url($certificates);exit;
       
       foreach($explore_data->get('field_certificate') as $key=>$images) {
           
           $certificates[]  = file_create_url($images->entity->getFileUri());
       }
        
        //print "abcs"
       //print_r($certificates);exit;
        
        if (!empty($university_nid)) {
       $univ_node = Node::load($university_nid);
       $univ_logo = file_create_url($univ_node->get('field_logo')->entity->uri->value);
        $univ_data[] = array(
        'university' =>Node::load($university_nid),
        'certificates' =>$certificates,
        'univ_logo' =>$univ_logo,
        
        );
        }
        
        
    
  
}

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
    
	$certificate = $why_course_data->get('field_sample_certification')->entity->getFileUri();
	$certificates_url = file_create_url($certificate);
	$why_course[] = array(
	  'degree' => $degree,
	  'issued_by' => $issued_by,
	  'logo_url' => $logo_url,
	  'certificates_url' => $certificates_url,
	);  
}

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
$course_description_tabs =  [
  '#theme' => 'course_description_tabs',
  '#overview' => $node->get('field_course_overview')->value,
  '#node' => $node,
  '#total_fee' => $node->get('field_course_total_fee')->value,
  '#univ_data' => $univ_data,
  '#logo' => $univ_data,
  '#course_team' => $course_team,
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
            
            foreach($course_data['modular_fee'] as $module_data) {
                $fee = $fee+ $module_data['fee'];
                $paragraph = Paragraph::create(['type' => 'course_module_details']);
                  $paragraph->set('field_course_module_fees', $module_data['fee']); 
                  $paragraph->set('field_course_module_ects_credit', 6); 
                  $paragraph->set('field_course_module_name', $module_data['fk_module_name']); 
                  $paragraph->save();
                   $current[] = array(
      'target_id' => $paragraph->id(),
      'target_revision_id' => $paragraph->getRevisionId(),
    );
            }
                $oldnode->set('field_course_modules', $current);
            
            foreach($course_data['fee_details'] as $module_fee_data) {
                $feeparagraph = Paragraph::create(['type' => 'course_fee_details']);
                  $feeparagraph->set('field_fee_label', $module_fee_data['fk_fee_detail']); 
                  $feeparagraph->set('field_paragraphh_module_fees', $module_fee_data['fee']); 
                 
                  $feeparagraph->save();
                   $feecurrent[] = array(
      'target_id' => $feeparagraph->id(),
      'target_revision_id' => $feeparagraph->getRevisionId(),
    );
            }
            
            
            
            
            
          
    
    $oldnode->set('field_course_module_fees', $feecurrent);

            $oldnode->save();
                   //     break;
                        }
                }
                

 
       }
    }

return array(
  '#markup' => '<h2>Course data updated from API</h2>',
);

  }
  

function search($word = false){
    

     
   /* $nodes =  \Drupal::entityTypeManager()->getStorage('node')
  ->loadByProperties(['type' => 'course', 'status' => 1]);*/
  
  $bundle='course';
     $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
    $query->condition('title' ,$_POST['search_key'] ,'CONTAINS');
    
    if(isset ($_POST['course_category'])) {
        $query->condition('field_course_category', $_POST['course_category']);
    }
    $query->condition('type', $bundle);
    $entity_ids = $query->execute();

        
 
    
    // Base theme path.
global $base_url;
$theme = \Drupal::theme()->getActiveTheme();

if(!empty($entity_ids)) {
$nodes = node_load_multiple($entity_ids);
}






$base_path = $base_url.'/'. $theme->getPath();
  $banner_block =  [
  '#theme' => 'course_search',
 '#base_path' => $base_path,
 '#node' => $nodes,
 '#search_key' => $_POST['search_key'],
 '#count' => count($nodes)
 
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



}