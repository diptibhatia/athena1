<?php
namespace Drupal\athena_course\Controller;
use Drupal\node\Entity\Node;

class AthenaCourseController {
  public function course($nid) {
    // New D8 procedural code.
   $parameters = \Drupal::routeMatch()->getParameters();  
$node = Node::load(14);

$banner_block =  [
  '#theme' => 'course_banner',
  '#course_title' => $node->get('title')->value,
  '#ects_credit' => $node->get('field_course_ects_credit')->value,
  '#awarding_body' => $node->get('field_course_awarding_body')->value,
  '#description' => $node->get('field_course_banner_description')->value,
  '#category' => $node->get('field_course_category')->value,
  '#banner' => $node->get('field_course_banner_image')->entity->uri->value,
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
];    

return array(
   $banner_block,
   $course_description_tabs,
);

  }
}