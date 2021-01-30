<?php

namespace Drupal\athena_library;

/**
 * extend Drupal's Twig_Extension class
 */
class StaticData extends \Twig_Extension {

  /**
   * {@inheritdoc}
   * Let Drupal know the name of your extension
   * must be unique name, string
   */
  public function getName() {
    return 'athena_library.staticData';
  }

  /**
   * {@inheritdoc}
   * Return your custom twig function to Drupal
   */
  public function getFunctions() {
    return [
      new \Twig_SimpleFunction('get_static_data', [$this, 'get_static_data']),
    ];
  }

  /**
   * Returns $_GET query parameter
   *
   * @param string $name
   *   name of the query parameter
   *
   * @return string
   *   value of the query parameter name
   */
  public function get_static_data($key, $textarea = FALSE) {
    return get_static_data($key, $textarea);
  }

}
