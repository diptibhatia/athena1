<?php

namespace Drupal\athena_course\Controller;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\Component\Serialization\Json;

use \Drupal\Core\Url;

class ShortTermCourseController {

    public function shortTermCourse(){
        $short_term_course =  [
          '#theme' => 'short_term_course'
        ];
        return array(
           $short_term_course
        );
    }

}
