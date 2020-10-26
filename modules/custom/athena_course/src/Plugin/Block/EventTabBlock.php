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
 *   id = "athena_event_tab_block",
 *   admin_label = @Translation("Event Tab Block"),
 * )
 */
class EventTabBlock extends BlockBase {
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
    
    $academicnodes = node_load_multiple($academic);
        
    }
     $popular_courses =  array_slice($academicnodes, 0, 3);
     
     
    
  //  print_r($academicnodes);exit;
    
    // Base theme path.
$theme = \Drupal::theme()->getActiveTheme();

$base_path = $base_url.'/'. $theme->getPath();
   $homepage_course_tabs =  [
  '#theme' => 'event_tab',
  '#course' => $popular_courses,
  '#base_path' => $base_path,

]; 

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