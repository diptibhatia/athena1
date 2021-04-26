<?php

namespace Drupal\search_insights\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Implements the SimpleForm form controller.
 *
 * @see \Drupal\Core\Form\FormBase
 */
class SearchInsightsForm extends FormBase {

  /**
   *
   * A build form method constructs an array that defines how markup and
   * other form elements are included in an HTML form.
   *
   * @param array $form
   *   Default form array structure.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Object containing current form state.
   *
   * @return array
   *   The render array defining the elements of the form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

  $form['search_insights'] = array(
      '#type' => 'textfield',
      '#title' => t('Search Our Insights'),
      '#size' => 14,      
      '#default_value' => \Drupal::request()->get('searchstring'),
    );


    $form['actions'] = [
      '#type' => 'actions',
    ];

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'image_button',
      '#src' => '/themes/custom/athena/images/search.svg',
    ];

    $form['#cache'] = ['max-age' => 0];

    return $form;
  }

  /**
   * Getter method for Form ID.
   *
   * @return string
   *   The unique ID of the form defined by this class.
   */
  public function getFormId() {
    return 'search_insights';
  }

  
  /**
   * Implements a form submit handler.
   *
   * The submitForm method is the default method called for any submit elements.
   *
   * @param array $form
   *   The render array of the currently built form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Object describing the current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {


    $search = $form_state->getValue('search_insights');

    $URL_path = explode('/',$_SERVER['REQUEST_URI']);

    if (in_array("blogs", $URL_path) )
        $URL = "/insights/blogs";
    elseif (in_array("all", $URL_path) )  
        $URL = "/insights/all";
    elseif (in_array("testimonials", $URL_path) )  
        $URL = "/insights/testimonials";
    elseif (in_array("news", $URL_path) )  
        $URL = "/insights/news";
    elseif (in_array("press-release", $URL_path) )  
        $URL = "/insights/press-release";
    elseif (in_array("book-review", $URL_path) )  
        $URL = "/insights/book-review";

    $current_path = \Drupal::service('path.current')->getPath();
    $node = \Drupal::routeMatch()->getParameter('node');
    if ($node instanceof \Drupal\node\NodeInterface) {
      $node_type = $node->getType();

      if ($node_type == 'testimonials') 
        $URL = "/insights/testimonials";        
    }  


    $response = Url::fromUserInput($URL.'?searchstring='.$search);
    $form_state->setRedirectUrl($response);
    
  }

}
