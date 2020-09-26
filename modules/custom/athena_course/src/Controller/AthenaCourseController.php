<?php
namespace Drupal\athena_course\Controller;
use Drupal\node\Entity\Node;

class AthenaCourseController {
  public function course($nid) {
    // New D8 procedural code.
   $parameters = \Drupal::routeMatch()->getParameters();  
$node = Node::load(14);
     return [
      '#theme' => 'course_banner',
      '#course_title' => $node->get('title')->value,
      '#ects_credit' => $node->get('field_course_ects_credit')->value,
      '#awarding_body' => $node->get('field_course_awarding_body')->value,
      '#description' => $node->get('field_course_banner_description')->value,
      '#category' => $node->get('field_course_category')->value,
      '#banner' => $node->get('field_course_banner_image')->entity->uri->value,
      '#node' => $node,
    ];    
      
      
  }
}