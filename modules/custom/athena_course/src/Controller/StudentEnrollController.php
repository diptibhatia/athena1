<?php

namespace Drupal\athena_course\Controller;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\Component\Serialization\Json;

use \Drupal\Core\Url;

class StudentEnrollController {
    public function StudentEnroltoCourse(){
     $render_array[] = [
      '#theme' => 'reg_redirect',
    ];
    return $render_array;
    }
}
