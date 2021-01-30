<?php

namespace Drupal\athena_library\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;

/**
 * Configure example settings for this site.
 */
class CentralizedConfiguration extends ConfigFormBase {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new CompletionRegister object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, Connection $connection) {
    $this->entityTypeManager = $entity_type_manager;
    $this->connection = $connection;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'), $container->get('database')
    );
  }

  /**
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'athena_library.common_settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'athena_library_centralized_configuration_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);
    $form['central_config'] = array(
      '#type' => 'vertical_tabs',
    );

    $form['static_blocks'] = array(
      '#type' => 'details',
      '#title' => t('Static Blocks'),
      '#collapsible' => TRUE,
      '#group' => 'central_config',
    );

    $form['static_blocks']['earning_a_degree'] = [
      '#type' => 'text_format',
      '#title' => 'Earning a Degree is Simplified With Athena',
      '#format' => 'full_html',
      '#default_value' => $config->get('earning_a_degree.value'),
      '#format' => $config->get('earning_a_degree.format'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->configFactory->getEditable(static::SETTINGS)
      // ->set('example1', $form_state->getValue('example1'))
      // ->set('example1', $form_state->getValue('example1'))
      ->set('earning_a_degree.value', $form_state->getValue('earning_a_degree')['value'])
      ->set('earning_a_degree.format', $form_state->getValue('earning_a_degree')['format'])

      ->save();
    parent::submitForm($form, $form_state);
  }

}
