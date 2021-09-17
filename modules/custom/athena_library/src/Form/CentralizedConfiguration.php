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

    $form['common_settings'] = array(
      '#type' => 'details',
      '#title' => t('Common Settings'),
      '#collapsible' => TRUE,
      '#group' => 'central_config',
    );

    $form['common_settings']['ulearn_portal_url'] = [
      '#type' => 'textfield',
      '#title' => 'Ulearn portal Url',
      '#default_value' => $config->get('ulearn_portal_url'),
    ];

    $form['common_settings']['lms_url'] = [
      '#type' => 'textfield',
      '#title' => 'LMS Url',
      '#default_value' => $config->get('lms_url'),
    ];

    $form['common_settings']['line_app_id'] = [
      '#type' => 'textfield',
      '#title' => 'Line App Id',
      '#default_value' => $config->get('line_app_id'),
    ];


    $form['verify_cetificate'] = array(
      '#type' => 'details',
      '#title' => t('Certificate Verification'),
      '#collapsible' => TRUE,
      '#group' => 'central_config',
    );

    $form['verify_cetificate']['course_details_default'] = [
      '#type' => 'text_format',
      '#title' => 'Course Details Default',
      '#format' => 'full_html',
      '#default_value' => $config->get('course_details_default.value'),
      '#format' => $config->get('course_details_default.format'),
    ];

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

    $form['static_blocks']['earning_a_degree_short_courses'] = [
      '#type' => 'text_format',
      '#title' => 'Earning a Block Chain Verified Certificate from Uniathena Short Courses',
      '#format' => 'full_html',
      '#default_value' => $config->get('earning_a_degree_short_courses.value'),
      '#format' => $config->get('earning_a_degree_short_courses.format'),
    ];

    $form['static_blocks']['seven_day_free_trial'] = [
      '#type' => 'text_format',
      '#title' => 'Take a 7-day free Trial',
      '#format' => 'full_html',
      '#default_value' => $config->get('seven_day_free_trial.value'),
      '#format' => $config->get('seven_day_free_trial.format'),
    ];

    $form['static_blocks']['how_you_learn'] = [
      '#type' => 'text_format',
      '#title' => 'How you learn',
      '#format' => 'full_html',
      '#default_value' => $config->get('how_you_learn.value'),
      '#format' => $config->get('how_you_learn.format'),
    ];

    $form['static_blocks']['footer_links'] = [
      '#type' => 'text_format',
      '#title' => 'Footer Links',
      '#format' => 'full_html',
      '#default_value' => $config->get('footer_links.value'),
      '#format' => $config->get('footer_links.format'),
    ];

    $form['static_blocks']['why_athena'] = [
      '#type' => 'text_format',
      '#title' => 'Why Athena',
      '#format' => 'full_html',
      '#default_value' => $config->get('why_athena.value'),
      '#format' => $config->get('why_athena.format'),
    ];

    $form['static_blocks']['ects_desc'] = [
          '#type' => 'text_format',
          '#title' => 'Ects Description',
          '#format' => 'full_html',
          '#default_value' => $config->get('ects_desc.value'),
          '#format' => $config->get('ects_desc.format'),
        ];


    $form['email_templates'] = array(
      '#type' => 'details',
      '#title' => t('Email Templates'),
      '#collapsible' => TRUE,
      '#group' => 'central_config',
    );

    $form['email_templates']['news_subscription_subject'] = [
      '#type' => 'textfield',
      '#title' => 'Subject',
      '#default_value' => $config->get('news_subscription_subject'),
    ];

    $form['email_templates']['news_subscription'] = [
      '#type' => 'text_format',
      '#title' => 'News Subscription',
      '#format' => 'full_html',
      '#default_value' => $config->get('news_subscription.value'),
      '#format' => $config->get('news_subscription.format'),
    ];


    $form['email_templates']['speak_to_advisor_subject'] = [
      '#type' => 'textfield',
      '#title' => 'Speak to advisor form email Subject',
      '#default_value' => $config->get('speak_to_advisor_subject'),
    ];

    $form['email_templates']['speak_to_advisor'] = [
      '#type' => 'text_format',
      '#title' => 'Speak to advisor form email template',
      '#format' => 'full_html',
      '#default_value' => $config->get('speak_to_advisor.value'),
      '#format' => $config->get('speak_to_advisor.format'),
    ];

    $form['email_templates']['get_in_touch_subject'] = [
      '#type' => 'textfield',
      '#title' => 'Get in touch form submission email subject',
      '#default_value' => $config->get('get_in_touch_subject'),
    ];

    $form['email_templates']['get_in_touch'] = [
      '#type' => 'text_format',
      '#title' => 'Get in touch form submission email template',
      '#format' => 'full_html',
      '#default_value' => $config->get('get_in_touch.value'),
      '#format' => $config->get('get_in_touch.format'),
    ];

    $form['email_templates']['enquiry_submission_subject'] = [
      '#type' => 'textfield',
      '#title' => 'Enquiry submission',
      '#default_value' => $config->get('enquiry_submission_subject'),
    ];

    $form['email_templates']['enquiry_submission'] = [
      '#type' => 'text_format',
      '#title' => 'Enquiry submission',
      '#format' => 'full_html',
      '#default_value' => $config->get('enquiry_submission.value'),
      '#format' => $config->get('enquiry_submission.format'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->configFactory->getEditable(static::SETTINGS)
      ->set('ulearn_portal_url', $form_state->getValue('ulearn_portal_url'))
      ->set('lms_url', $form_state->getValue('lms_url'))
      ->set('line_app_id', $form_state->getValue('line_app_id'))

      ->set('course_details_default.value', $form_state->getValue('course_details_default')['value'])
      ->set('course_details_default.format', $form_state->getValue('course_details_default')['format'])

      ->set('earning_a_degree.value', $form_state->getValue('earning_a_degree')['value'])
      ->set('earning_a_degree.format', $form_state->getValue('earning_a_degree')['format'])

      ->set('earning_a_degree_short_courses.value', $form_state->getValue('earning_a_degree_short_courses')['value'])
      ->set('earning_a_degree_short_courses.format', $form_state->getValue('earning_a_degree_short_courses')['format'])


      ->set('seven_day_free_trial.value', $form_state->getValue('seven_day_free_trial')['value'])
      ->set('seven_day_free_trial.format', $form_state->getValue('seven_day_free_trial')['format'])
      
      ->set('how_you_learn.value', $form_state->getValue('how_you_learn')['value'])
      ->set('how_you_learn.format', $form_state->getValue('how_you_learn')['format'])

      ->set('footer_links.value', $form_state->getValue('footer_links')['value'])
      ->set('footer_links.format', $form_state->getValue('footer_links')['format'])

      ->set('why_athena.value', $form_state->getValue('why_athena')['value'])
      ->set('why_athena.format', $form_state->getValue('why_athena')['format'])

      ->set('ects_desc.value', $form_state->getValue('ects_desc')['value'])
      ->set('ects_desc.format', $form_state->getValue('ects_desc')['format'])


      ->set('news_subscription_subject', $form_state->getValue('news_subscription_subject'))
      ->set('news_subscription.value', $form_state->getValue('news_subscription')['value'])
      ->set('news_subscription.format', $form_state->getValue('news_subscription')['format'])

      ->set('get_in_touch_subject', $form_state->getValue('get_in_touch_subject'))
      ->set('get_in_touch.value', $form_state->getValue('get_in_touch')['value'])
      ->set('get_in_touch.format', $form_state->getValue('get_in_touch')['format'])

      ->set('speak_to_advisor_subject', $form_state->getValue('speak_to_advisor_subject'))
      ->set('speak_to_advisor.value', $form_state->getValue('speak_to_advisor')['value'])
      ->set('speak_to_advisor.format', $form_state->getValue('speak_to_advisor')['format'])

      ->set('enquiry_submission_subject', $form_state->getValue('enquiry_submission_subject'))
      ->set('enquiry_submission.value', $form_state->getValue('enquiry_submission')['value'])
      ->set('enquiry_submission.format', $form_state->getValue('enquiry_submission')['format'])

      ->save();
    parent::submitForm($form, $form_state);
  }

}
