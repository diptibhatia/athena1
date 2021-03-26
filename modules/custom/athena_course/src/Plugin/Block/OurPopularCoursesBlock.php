<?php

namespace Drupal\athena_course\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

use \Drupal\Core\Url;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "our_popular_courses",
 *   admin_label = @Translation("Our Popular Courses Block"),
 * )
 */
class OurPopularCoursesBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */

  public function build() {
      
    global $base_url;

 
    // get current nodeid 
    $node = \Drupal::routeMatch()->getParameter('node');
    if ($node instanceof \Drupal\node\NodeInterface) {
    // You can get nid and anything else you need from the node object.
    $nid = $node->id();
    }

        
    

  // Base theme path.
  $theme = \Drupal::theme()->getActiveTheme();
  
  
  //popular courses
  
    $ip = $_SERVER['REMOTE_ADDR']; // This will contain the ip of the request

// You can use a more sophisticated method to retrieve the content of a webpage with php using a library or something
// We will retrieve quickly with the file_get_contents
$dataArray = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));


$ccd = $dataArray->geoplugin_countryCode;

$key = "field_is_popular_course";
$value = 1;
if(!empty($ccd)) {
    
    $key = "field_course_country";
    $value = $ccd;
}


  $bundle='course';
     $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
  //  $query->condition('field_course_academic_route', 'academic', 'CONTAINS');
$query->condition($key, $value, '=');
    $query->condition('type', $bundle);
    $academic = $query->execute();
    
    //$academicnodes = node_load_multiple($academic);
    
    if(empty($academicnodes)) {
          $bundle='course';
     $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
  //  $query->condition('field_course_academic_route', 'academic', 'CONTAINS');
$query->condition('field_is_popular_course', '1', '=');
    $query->condition('type', $bundle);
    $academic = $query->execute();
    
    $academicnodes = node_load_multiple($academic);
        
    }
     $popular_courses =  array_slice($academicnodes, 0, 2);
     
     $aggregated_data = array();
     foreach($popular_courses as $node) {
         if(is_object( $node->field_link_universities)){
            $paragraph_univ_data = $node->field_link_universities->referencedEntities();
        }
    $univ_data = array();
    foreach($paragraph_univ_data as $explore_data) {
        $university_nid = $explore_data->get('field_university')->value;
        $university_nid = $explore_data->get('field_university')->value;
        if (!empty($university_nid)) {
       $univ_node = Node::load($university_nid);
       $univ_logo = file_create_url($univ_node->get('field_logo')->entity->uri->value);
        $univ_data[] = $univ_logo;
       }
    }

     $univ_popular[] = $univ_data;
     $aggregated_data[] = array(
     'node' => $node,
     'univ' =>  $univ_data,
     );
     

     }
     

  $base_path = $base_url.'/'. $theme->getPath();
    $our_popular_courses =  [
    '#theme' => 'our_popular_courses',    
    '#popular' => $aggregated_data,
    '#base_path' => $base_path,
    '#univ_popular' => $univ_popular,

  ]; 

    return array($our_popular_courses);
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['my_block_settings'] = $form_state->getValue('my_block_settings');
  }
}