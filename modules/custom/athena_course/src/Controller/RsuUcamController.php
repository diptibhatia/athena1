<?php

namespace Drupal\athena_course\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use \Drupal\node\Entity\Node;

class RsuUcamController {

    /**
     * RSU UCAM Page.
     * @return [array]
     */
    public function index() {
        $build =  [
          '#theme' => 'rsu_ucam',
          '#attached' => [
            'library' => [
                'core/jquery',
                'core/drupal.ajax'
            ]
          ]
        ];
        return array(
           $build
        );
    }

}
