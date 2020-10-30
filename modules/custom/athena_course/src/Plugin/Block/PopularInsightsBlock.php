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
 *   id = "popular_insights_block",
 *   admin_label = @Translation("Popular Insights Block"),
 * )
 */
class PopularInsightsBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
      
    global $base_url;

    $bundle='insight_article';

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
    $popular_insights =  [
    '#theme' => 'popular_insights',
    '#popu' => $testimo,
    '#base_path' => $base_path,

  ]; 

    return array($popular_insights);
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