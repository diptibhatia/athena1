<?php

/**
 * @file
 * Helper class for common used functions.
 */

namespace Drupal\athena_library\Utils;

use Drupal\file\Entity\File;

class CommonHelper {

  /**
   * Get config variable value.
   */
  public static function getConfigSettings($service_name, $variable) {
    $config = \Drupal::config($service_name);
    $value = $config->get($variable);
    return $value;
  }

  /**
   * Get Image Url for given file id.
   *
   * @param string $target_id
   *   Image file id.
   *
   * @return string
   *   Image Url for given file id or NULL  if not found.
   */
  public static function geImageUri($target_id) {
    if ($target_id) {
      $file = File::load($target_id);
      if ($file) {
        return file_create_url($file->getFileUri());
      }
    }
    return NULL;
  }

}
