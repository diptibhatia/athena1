<?php

namespace Drupal\athena_course\Controller;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\Component\Serialization\Json;

use \Drupal\Core\Url;

class ShortTermCourseController {

    public function shortTermCourse(){
        $short_term_courses ='short_term_courses';
        $query = \Drupal::entityQuery('node');
        $query->condition('status', 1);
        $query->condition('type', $short_term_courses);
        $latest = $query->execute();
        $short_term_courses_nodes = node_load_multiple($latest);

        $short_term_course =  [
          '#theme' => 'short_term_course',
          '#nodes' => $short_term_courses_nodes,
        ];
        return array(
           $short_term_course
        );
    }

}
