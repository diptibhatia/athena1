<?php

/**
 * @file
 * Definition of Drupal\read_time\Plugin\views\field\ReadTime.
 */

namespace Drupal\read_time\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\NodeType;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;


/**
 * Field handler for read time.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("read_time")
 */
class ReadTime extends FieldPluginBase {

  /**
   * @{inheritdoc}
   */
  public function query() {
    // Leave empty to avoid a query on this field.
  }

  /**
   * Define the available options
   * @return array
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['link_to_entity'] = [0];
    return $options;
  }

  /**
   * Provide the options form.
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    $form['link_to_entity'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Link to the Content'),
      '#default_value' => $this->options['link_to_entity'],
    ];
    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * @{inheritdoc}
   */
  public function render(ResultRow $values) {
    //$entity = $values->_entity;
    $entity = $this->getEntity($values);
    
    $defaults = read_time_defaults();
    $node_type = $entity->type->entity;
    $format = $node_type->getThirdPartySetting('read_time', 'read_time_format', $defaults['format']);
    $display = $node_type->getThirdPartySetting('read_time', 'read_time_display', $defaults['display']);

    $time = \Drupal::database()
      ->select('read_time', 'r')
      ->fields('r', ['read_time'])
      ->condition('r.nid', $entity->id())
      ->execute()
      ->fetchField();

    if (empty($time) || $time == 0) {
      $time = read_time_calculate($entity);
      
      \Drupal::database()->merge('read_time')
        ->key(['nid' => $entity->id()])
        ->fields([
          'read_time' => $time,
        ])
        ->execute();
    }

    // Format read time.
    if (in_array($format, array('hour_short', 'hour_long'))) {
      $hours = floor($time / 60);
      $minutes = ceil(fmod($time, 60));
    } else {
      $minutes = ceil($time);
    }
    if (in_array($format, array('hour_long', 'min_long'))) {
      $hour_suffix = 'hour';
      $min_suffix = 'minute';
    } else {
      $hour_suffix = 'hr';
      $min_suffix = 'min';
    }
    $minute_format = \Drupal::translation()->formatPlural($minutes, '1 ' . $min_suffix, '@count ' . $min_suffix . 's');
    if (!empty($hours)) {
      $hour_format = \Drupal::translation()->formatPlural($hours, '1 ' . $hour_suffix, '@count ' . $hour_suffix . 's');
      $read_time = format_string('@h, @m', array('@h' => $hour_format, '@m' => $minute_format));
    } else {
      $read_time = $minute_format;
    }
   
    if($this->options['link_to_entity'] == 1) {
      $build = $entity->toLink()->toRenderable();
      $build['#title'] = t((string) $display, [':read_time' => strtoupper($read_time)]);
    } else {
      $build = t((string) $display, [':read_time' => strtoupper($read_time)]);
    }
    return  $build;
  }
}
