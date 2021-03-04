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
 *   id = "athena_course_save_contact",
 *   label = @Translation("Get in touch contact details"),
 *   uri_paths = {
 *     "https://www.drupal.org/link-relations/create" = "/save/contact",
 *   }
 * )
 */
class ContactResources extends ResourceBase
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
    public function post($data)
    {
        foreach ($data as $key => $value) {
            $formatData = strip_tags($value);
            $formatData = trim($formatData);
            $data[$key] = substr($formatData,0, 200);
            if (empty($value)) {
                $data[$key] = '';
            }
        }

        $title = implode('-', $data);

        $type = $data['type'] ?? '';
        if (!empty($type)) {
            $enquiry = Node::create(['type' => 'news_letter']);
            $enquiry->set('title', $data['mail']);
            $enquiry->enforceIsNew();
        }
        else {
            $enquiry = Node::create(['type' => 'enquiry_submissions']);
            $enquiry->set('title', $title);
            $enquiry->set('field_form_id', $data['form_id']);
            $enquiry->set('field_course_title', $data['course']);
            $enquiry->set('field_first_name', $data['fname']);
            $enquiry->set('field_last_name', $data['lname']);
            $enquiry->set('field_contact_number', $data['phone']);
            $enquiry->enforceIsNew();
        }

        $enquiry->save();

        $response_status = [];
        $message = "Thank you!! we'll get in touch with you shortly";
        $response_status = ['message' => $message];
        $response = new ResourceResponse($response_status);
        return $response;
    }
}
