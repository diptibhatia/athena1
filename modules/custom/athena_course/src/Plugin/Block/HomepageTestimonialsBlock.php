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
 *   id = "homepage_testimonials_block",
 *   admin_label = @Translation("Homepage Testimonials Block"),
 * )
 */
class HomepageTestimonialsBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
      
    global $base_url;

    $bundle='testimonials';

    $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
    $query->condition('type', $bundle);
    $latest = $query->execute();
        
    
    $testinodes = node_load_multiple($latest);
        
    $testimo =  array_slice($testinodes, 0, 3);
    //echo "<pre>";     
    //print_r($testimo);exit;

  // Base theme path.
  $theme = \Drupal::theme()->getActiveTheme();

  $base_path = $base_url.'/'. $theme->getPath();
    $homepage_testimonials =  [
    '#theme' => 'homepage_testimonials',
    '#testi' => $testimo,
    '#base_path' => $base_path,

  ]; 

    return array($homepage_testimonials);
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