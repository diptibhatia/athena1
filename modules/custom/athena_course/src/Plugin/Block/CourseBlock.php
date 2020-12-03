<?php

namespace Drupal\athena_course\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

use \Drupal\Core\Url;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "my_block_example_block",
 *   admin_label = @Translation("My block"),
 * )
 */
class CourseBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
      
      global $base_url;
      


  $bundle='course';
     $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
  //  $query->condition('field_course_academic_route', 'academic', 'CONTAINS');
$query->condition('field_course_category', 'Academic');
    $query->condition('type', $bundle);
    $academic = $query->execute();
    
    
     $microquery = \Drupal::entityQuery('node');
    $microquery->condition('status', 1);
    $microquery->condition('field_course_category',  'Micro Credits', '=');
    $microquery->condition('type', $bundle);
     $micro = $microquery->execute();
    
    
     $querycertification = \Drupal::entityQuery('node');
    $querycertification->condition('status', 1);
    $querycertification->condition('field_course_category', 'Certifications', '=');
    $querycertification->condition('type', $bundle);
     $certifications = $querycertification->execute();

    $academicnodes = node_load_multiple($academic);
    $micronodes = node_load_multiple($micro);
    $certificationsnodes = node_load_multiple($certifications);
    
   // $academicnodes =  array_slice($academicnodes, 0, 10);
    $micronodes =  array_slice($micronodes, 0, 10);
    $certificationsnodes =  array_slice($certificationsnodes, 0, 10);
    
   // print_r($certificationsnodes);exit;
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
        $acaddesc = $explore_data->get('field_explore_course_banner_desc')->value;
        $header_image = $explore_data->get('field_header_background_image')->value;
        $header_image = $explore_data->get('field_header_background_image')->entity->getFileUri();
        $url = file_create_url($header_image);
       
    }elseif ($type == 'Micro Credits') {
        $title1 = 'Academic';
        $title2 = 'Programs';
        $microdesc = $explore_data->get('field_explore_course_banner_desc')->value;
        $header_image = $explore_data->get('field_header_background_image')->value;
        $header_image = $explore_data->get('field_header_background_image')->entity->getFileUri();
        $url = file_create_url($header_image);
       
    }
    elseif ($type == 'Certifications') {
        $title1 = 'Certifications';
        $title2 = 'Programs';
        $cerdesc = $explore_data->get('field_explore_course_banner_desc')->value;
        $header_image = $explore_data->get('field_header_background_image')->value;
        $header_image = $explore_data->get('field_header_background_image')->entity->getFileUri();
        $url = file_create_url($header_image);
       
    }
    
}

    
    // Base theme path.
$theme = \Drupal::theme()->getActiveTheme();

$base_path = $base_url.'/'. $theme->getPath();
   $homepage_course_tabs =  [
  '#theme' => 'course_homepage_tabs',
  '#academic' => $academicnodes,
  '#micro' => $micronodes,
  '#certifications' => $certificationsnodes,
  '#acaddesc' => $acaddesc,
  '#microdesc' => $microdesc,
  '#cerdesc' => $cerdesc,
  '#base_path' => $base_path,

]; 

    return array($homepage_course_tabs);
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['my_block_settings'] = $form_state->getValue('my_block_settings');
  }
}