<?php

namespace Drupal\athena_course\Plugin\rest\resource;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Drupal\Core\Session\AccountProxyInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use \Drupal\node\Entity\Node;

/**
 * Annotation for post method
 *
 * @RestResource(
 *   id = "athena_course_send_mail",
 *   label = @Translation("Send mail"),
 *   uri_paths = {
 *     "https://www.drupal.org/link-relations/create" = "/send/mail",
 *   }
 * )
 */
class SendMail extends ResourceBase
{
    /**
     * A current user instance.
     *
     * @var \Drupal\Core\Session\AccountProxyInterface
     */
    protected $currentUser;

    /**
     * Constructs a Drupal\rest\Plugin\ResourceBase object.
     *
     * @param array $configuration
     *   A configuration array containing information about the plugin instance.
     * @param string $plugin_id
     *   The plugin_id for the plugin instance.
     * @param mixed $plugin_definition
     *   The plugin implementation definition.
     * @param array $serializer_formats
     *   The available serialization formats.
     * @param \Psr\Log\LoggerInterface $logger
     *   A logger instance.
     * @param \Drupal\Core\Session\AccountProxyInterface $current_user
     *   A current user instance.
     */
    public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        array $serializer_formats,
        LoggerInterface $logger,
        AccountProxyInterface $current_user)
    {parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);$this->currentUser = $current_user;
    }


    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
    {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->getParameter('serializer.formats'),
            $container->get('logger.factory')->get('custom_rest'),
            $container->get('current_user')
        );
    }


    /**
     * Responds to POST requests.
     *
     * Returns a list of bundles for specified entity.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *   Throws exception expected.
     */
    public function post($data) {
        global $base_url;
        $form_id = $data['form_id'];
        $tokens = array();
        $tokens['name'] = 'user';
        switch ($form_id) {
            case 'news-letter-subscribe':
                $template = get_static_data('news_subscription', true);
                $params['subject'] = get_static_data('news_subscription_subject');
                $tokens['link'] = $base_url  . '/insights/all';
                $key = 'news_subscription';
                break;
            case 'get_in_touch':
                $template = get_static_data('get_in_touch', true);
                $params['subject'] = get_static_data('get_in_touch_subject');
                $tokens['link'] = $base_url  . '/course-home';
                $key = 'get_in_touch';
                break;
            case 'speak_to_advisor':
            case 'course_speak_to_advisor':
                $template = get_static_data('speak_to_advisor', true);
                $params['subject'] = get_static_data('speak_to_advisor_subject');
                $tokens['link'] = $base_url  . '/registration';
                $key = 'speak_to_advisor';
                break;
        }

        foreach ($tokens as $key => $value) {
            $template = str_replace('@' . $key, $value, $template);
        }

        $mailManager = \Drupal::service('plugin.manager.mail');
        $module = 'athena_course';

        $to = $data['to'];
        $params['message'] = $template;
        $langcode = \Drupal::currentUser()->getPreferredLangcode();
        $send = true;
        $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
        if ($result['result'] !== true) {
            $response_status = ['message' => 'Mail not sent'];
        }
        else {
            $response_status = ['message' => 'Mail sent'];
        }

        \Drupal::messenger()->deleteAll();

        $response = new ResourceResponse($response_status);
        return $response;
    }
}
