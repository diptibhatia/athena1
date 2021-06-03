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
 *   id = "website_subscribe_popup",
 *   admin_label = @Translation("Website Subscribe Popup"),
 * )
 */
class WebsiteSubscribe extends BlockBase {

  public function getCacheMaxAge() {
      return 0;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $subscribed = 0;
    $cookie_name = "website_subscribe";
    if(isset($_COOKIE[$cookie_name])) {
      $subscribed = 1;
    }
    $template = [
      '#theme' => 'website_subscribe_popup',
      '#subscribed' => $subscribed
    ];
    return array($template);
  }

}
