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
   
  public function getCacheMaxAge() {
    return 0;
  }

  public function build() {
    $parameters = \Drupal::routeMatch()->getParameters(); 
    if(isset($_REQUEST['discussion_id'])) {
      $discussion_id = $_REQUEST['discussion_id'];
    }
    $end_url = 'http://3.7.173.255/athenadev/api/';
    $end_url = 'https://learn.athena.edu/athenaprod/api/';
    $client = \Drupal::service('http_client_factory')->fromOptions([
      'base_uri' => $end_url,
    ]);
    $response = $client->get('discussions');
    $discussions = Json::decode($response->getBody());
    // Base theme path.
    $theme = \Drupal::theme()->getActiveTheme();

    $data_final = [];
    foreach($discussions['data']['data'] as $data) {
      $data['author_profile_pic'] = $this->checkFileExist($data['author_profile_pic']);
      $data_final[] = $data;
    }

    $base_path = $base_url.'/'. $theme->getPath();
      $homepage_course_tabs =  [
      '#theme' => 'discussions',
      '#discussions' => $data_final,
      '#base_path' => $base_path,

    ]; 

    if(!empty($discussion_id)) {
        $client_detal = \Drupal::service('http_client_factory')->fromOptions([
          'base_uri' => $end_url,
        ]);
        $response_detail = $client_detal->get('discussions/'.$discussion_id);
        $post = $client_detal->get('wreply/'.$discussion_id);

        $discussion = Json::decode($response_detail->getBody());
        $posts = Json::decode($post->getBody());
        $discussion['data']['author_profile_pic'] = $this->checkFileExist($discussion['data']['author_profile_pic']);
          
          $discussion_detail =  [
          '#theme' => 'discussions_detail',
          '#discussion' => $discussion['data'],
          '#post' => $posts['data']['posts'],
          '#base_path' => $base_path,
          '#cache' => [ 'max-age'=>0 ],
          '#block' => $block
        ];  
      return array($discussion_detail);
      }
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

  // Return default imag eif image not exist
  public function checkFileExist($f) {
      $url = getimagesize($f);
      if(!is_array($url)) {
          return '/themes/custom/athena/images/avatar.png';
      }
      else {
        return $f;
      }
  }
}