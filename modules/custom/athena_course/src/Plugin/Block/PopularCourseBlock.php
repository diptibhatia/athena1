<?php

namespace Drupal\athena_course\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

use \Drupal\Core\Url;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "athena_popular_course_block",
 *   admin_label = @Translation("Popular Course Block"),
 * )
 */
class PopularCourseBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
      
    global $base_url;
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
      $popular_courses_arr = node_load_multiple($academic);
          
    }
    
    // data for row1 
    if (!empty($popular_courses_arr) && $popular_courses_arr != "")    
      $popular_courses_row1 =  array_slice($popular_courses_arr, 0, 3);      
    
    foreach ($popular_courses_row1 as $node) 
    {
      if(is_object( $node->field_link_universities))
        $paragraph_univ_data = $node->field_link_universities->referencedEntities();
      
      $i=0;
      foreach($paragraph_univ_data as $explore_data) 
      {
        if ( $i==0 )
        {
          $university_nid = $explore_data->get('field_university')->value;
          break;  
        }       
      }

      $white_log = array();      
      if (!empty($university_nid) && $university_nid != "")
        $white_logo[] = getUniversityWhiteLogo($university_nid);
    }

    // data for row2 
    if (!empty($popular_courses_arr) && $popular_courses_arr != "")    
        $popular_courses_row2 =  array_slice($popular_courses_arr, 3, 3);     

    foreach ($popular_courses_row2 as $node) 
    {
      if(is_object( $node->field_link_universities))
        $paragraph_univ_data = $node->field_link_universities->referencedEntities();
      
      $i=0;
      foreach($paragraph_univ_data as $explore_data) 
      {
        if ( $i==0 )
        {
          $university_nid = $explore_data->get('field_university')->value;
          break;  
        }       
      }
      
      if (!empty($university_nid) && $university_nid != "")
        $white_logo[] = getUniversityWhiteLogo($university_nid);
    }
 
    //print_r($white_logo);exit;
    
    // Base theme path.
  $theme = \Drupal::theme()->getActiveTheme();

   $base_path = $base_url.'/'. $theme->getPath();
    $homepage_course_tabs =  [
      '#theme' => 'popular_course',
      '#courses_row1' => $popular_courses_row1,
      '#courses_row2' => $popular_courses_row2,
      '#white_logo'  => $white_logo,
      '#base_path' => $base_path,
];

//print_r($homepage_course_tabs); exit; 

    return array($homepage_course_tabs);
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