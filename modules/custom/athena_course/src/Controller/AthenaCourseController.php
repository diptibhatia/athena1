<?php
namespace Drupal\athena_course\Controller;
use Drupal\node\Entity\Node;
use Drupal\Component\Serialization\Json;

class AthenaCourseController {
  public function course($nid) {
    // New D8 procedural code.
   $parameters = \Drupal::routeMatch()->getParameters();  

$node = Node::load($nid);

// Base theme path.
global $base_url;
$theme = \Drupal::theme()->getActiveTheme();
$base_path = $base_url.'/'. $theme->getPath();

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

$course_description_tabs =  [
  '#theme' => 'course_description_tabs',
  '#overview' => $node->get('field_course_overview')->value,
  '#node' => $node,
  '#total_fee' => $node->get('field_course_total_fee')->value,
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

    foreach ($courses as $key => $course_data) {
      $cid = $course_data['cid'];
       
        if(!in_array($cid, $node_ids)) {
          $new_node = Node::create(['type' => 'course']);
          $new_node->set('title',$course_data['course_name']);
          $new_node->set('field_course_total_credits', $course_data['ects_credit']);
          $new_node->set('field_course_awarding_body', $course_data['awarded_by']);
          $new_node->set('field_course_overview', $course_data['course_introduction']);
          $new_node->set('field_cid', $cid);
          $new_node->save();      
        } else {
               foreach($nodes as $node_key => $oldnode) {
                if($oldnode->get('field_cid')->value == $cid) {
                         $oldnode->set('title',$course_data['course_name']);
            $oldnode->set('field_course_total_credits', $course_data['ects_credit']);
             $oldnode->set('field_course_awarding_body', $course_data['awarded_by']);
            $oldnode->set('field_course_overview', $course_data['course_introduction']);

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
  

}