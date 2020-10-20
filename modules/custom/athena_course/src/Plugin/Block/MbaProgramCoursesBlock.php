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
 *   id = "athena_mba_program_courses_block",
 *   admin_label = @Translation("Mba Program Courses Block"),
 * )
 */
class MbaProgramCoursesBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
      
  global $base_url;

    $key = "field_course_category";
    $value = "Academic";


    $bundle='course';
    $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
    //  $query->condition('field_course_academic_route', 'academic', 'CONTAINS');
    $query->condition($key, $value, '=');
    $query->condition('type', $bundle);
    $academic = $query->execute();

    //$academicnodes = node_load_multiple($academic);
    
    if(empty($academicnodes)) {
        $bundle='course';
        $query = \Drupal::entityQuery('node');
        $query->condition('status', 1);
        //  $query->condition('field_course_academic_route', 'academic', 'CONTAINS');
        $query->condition('field_course_category', 'Academic', '=');
        $query->condition('type', $bundle);
        $academic = $query->execute();
    
        $academicnodes = node_load_multiple($academic);
        
    }
    $popular_courses =  array_slice($academicnodes, 0, 3);
     
     
    
    //  print_r($academicnodes);exit;
    
    // Base theme path.
    $theme = \Drupal::theme()->getActiveTheme();

    $base_path = $base_url.'/'. $theme->getPath();
    $homepage_course_tabs =  [
      '#theme' => 'mba_program_courses',
      '#course' => $popular_courses,
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