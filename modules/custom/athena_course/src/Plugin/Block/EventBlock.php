<?php

namespace Drupal\athena_course\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

use \Drupal\Core\Url;

class EventBlock extends BlockBase {

  public function build() {
      
    global $base_url;
      


    $bundle='events';
    
    $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
    $query->condition('field_event_category', 'Upcoming', '=');
    $query->condition('type', $bundle);
    $upcoming = $query->execute();
    
    $pastquery = \Drupal::entityQuery('node');
    $pastquery->condition('status', 1);
    $pastquery->condition('field_event_category',  'Past', '=');
    $pastquery->condition('type', $bundle);
    $past = $pastquery->execute();

    $upcomingnodes = node_load_multiple($upcoming);
    $pastnodes = node_load_multiple($past);
    
    $upcomingnodes =  array_slice($upcomingnodes, 0, 2);
    $pastnodes =  array_slice($pastnodes, 0, 2);
    
   // print_r($pastnodes);exit;
    
    // Base theme path.
    $theme = \Drupal::theme()->getActiveTheme();

    $base_path = $base_url.'/'. $theme->getPath();
      $event_page_tabs =  [
      '#theme' => 'event_page_tabs',
      '#upcoming' => $upcomingnodes,
      '#past' => $pastnodes,
      '#base_path' => $base_path,
    ]; 

    return array($event_page_tabs);
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