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
 *   id = "athena_university_block",
 *   admin_label = @Translation("University Partners Block"),
 * )
 */
class UniversityBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
           public function getCacheMaxAge() {
    return 0;
  }

  public function build() {
      
      global $base_url;
      


  $bundle='course';
     $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
  //  $query->condition('field_course_academic_route', 'academic', 'CONTAINS');
$query->condition('field_is_popular_course', '1', '=');
    $query->condition('type', $bundle);
    $academic = $query->execute();
    
    $academicnodes = node_load_multiple($academic);
     $popular_courses =  array_slice($academicnodes, 0, 3);
     
      $bundle='insight_article';

    $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
    $query->condition('type', $bundle);
      $query->sort('changed' , 'DESC'); 
    $latest = $query->execute();
        
    
    $insightsnodes = node_load_multiple($latest);
    
    $last_insight = array_slice($insightsnodes, 0, 1);

    $latest_insights =  array_slice($insightsnodes, 1, 5);
    
  //  print_r($academicnodes);exit;

// Get the block id through config, SQL or some other means
$bid = 19; // staging block id
//$bid = 21; //localhost block id
$block = \Drupal\block_content\Entity\BlockContent::load($bid);
$render = \Drupal::entityTypeManager()->
  getViewBuilder('block_content')->view($block);
    
    // Base theme path.
$theme = \Drupal::theme()->getActiveTheme();

$base_path = $base_url.'/'. $theme->getPath();
   $homepage_course_tabs =  [
  '#theme' => 'universities',
  '#course' => $popular_courses,
  '#render' => $render,
  '#last_insight' => $last_insight, 
  '#insig' => $latest_insights,
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