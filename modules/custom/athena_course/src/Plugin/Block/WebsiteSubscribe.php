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

  /**
   * {@inheritdoc}
   */
  public function build() {
    $cookie_name = "website_popup";
    $cookie_value = TRUE;

    $subscribed = FALSE;
    // if(!isset($_COOKIE[$cookie_name])) {
    //   setcookie($cookie_name, $cookie_value, time() + (86400 * 365), "/");
    //   $_COOKIE[$cookie_name] = $cookie_value;
    // }
    // else {
    //   $subscribed = TRUE;
    // }

    $template = [
      '#theme' => 'website_subscribe_popup',
      '#subscribed' => $subscribed
    ];
    return array($template);
  }

}
