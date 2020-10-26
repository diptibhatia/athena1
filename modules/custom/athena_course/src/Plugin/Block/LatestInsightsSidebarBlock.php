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
 *   id = "latest_insights_sidebar_block",
 *   admin_label = @Translation("Latest Insights Sidebar Block"),
 * )
 */
class LatestInsightsSidebarBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
      
    global $base_url;

    $bundle='insight_article';
    $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
    $query->condition('type', $bundle);
    $insights = $query->execute();
        
    
    $insightsnodes = node_load_multiple($insights);
        
    }
     $latest_insights =  array_slice($insightsnodes, 0, 5);
         
  // Base theme path.
  $theme = \Drupal::theme()->getActiveTheme();

  $base_path = $base_url.'/'. $theme->getPath();
    $latest_insights_sidebar =  [
    '#theme' => 'latest_insights_sidebar',
    '#insights' => $latest_insights,
    '#base_path' => $base_path,

  ]; 

    return array($latest_insights_sidebar);
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