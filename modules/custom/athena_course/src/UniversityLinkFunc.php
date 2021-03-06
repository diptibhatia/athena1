<?php

namespace Drupal\athena_course;


/**
 * extend Drupal's Twig_Extension class
 */
class UniversityLinkFunc extends \Twig_Extension {

  /**
   * {@inheritdoc}
   * Let Drupal know the name of your extension
   * must be unique name, string
   */
  public function getName() {
    return 'athena_course.universitylink';
  }


  /**
   * {@inheritdoc}
   * Return your custom twig function to Drupal
   */
  public function getFunctions() {
    return [
      new \Twig_SimpleFunction('get_university_link', [$this, 'get_university_link']),
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
  public function get_university_link($name) {
    return get_university_link($name);
  }

}
