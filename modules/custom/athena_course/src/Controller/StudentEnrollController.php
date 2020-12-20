<?php

namespace Drupal\athena_course\Controller;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\Component\Serialization\Json;

use \Drupal\Core\Url;

class StudentEnrollController {

    public function StudentEnroltoCourse(){
        return array(
            '#type' => 'markup',
            '#markup' => '<h1 class="top-search-section__title"><span>' . t('Thank you for registration. Please wait we are redirecting ...') . '</span></h1><a class="student_enroll_link"> click here</a> if you are not redirected.'
        );
    }

}
