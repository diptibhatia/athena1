<?php

namespace Drupal\athena_course\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

use \Drupal\Core\Url;
use Drupal\Component\Serialization\Json;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "athena_discussions_block",
 *   admin_label = @Translation("Discussions"),
 * )
 */
class DiscussionsBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
      
      
       $client = \Drupal::service('http_client_factory')->fromOptions([
      'base_uri' => 'http://3.7.173.255/athenadev/api/',
    ]);

    $response = $client->get('discussions');

    $discussions = Json::decode($response->getBody());
    
    //print_r($discussions);exit;
     
    // Base theme path.
$theme = \Drupal::theme()->getActiveTheme();

$base_path = $base_url.'/'. $theme->getPath();
   $homepage_course_tabs =  [
  '#theme' => 'discussions',
  '#discussions' => $discussions['data']['data'],
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