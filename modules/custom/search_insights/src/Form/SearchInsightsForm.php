<?php

namespace Drupal\search_insights\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Implements the SimpleForm form controller.
 *
 * This example demonstrates a simple form with a single text input element. We
 * extend FormBase which is the simplest form base class used in Drupal.
 *
 * @see \Drupal\Core\Form\FormBase
 */
class SearchInsightsForm extends FormBase {

  /**
   * Build the simple form.
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

/*    
$form['search_insights'] = array(
  '#type'=> 'item',
  '#prefix' => "<div class='search'>",
  '#suffix' => '</div>',
  );
*/
  $form['search_insights'] = array(
      '#type' => 'textfield',
      '#title' => t('Search Our Insights'),
      '#size' => 14,      
      //'#prefix' => "<div class='search'>",
      //'#suffix' => '</div>',
      //'#attributes' => array('class' => array('search-form')),
      '#default_value' => \Drupal::request()->get('searchstring'),
    );


    //$form['search_insights']['#attributes']['class'][] = 'search-form';
    // Group submit handlers in an actions element with a key of "actions" so
    // that it gets styled correctly, and so that other modules may add actions
    // to the form. This is not required, but is convention.
    $form['actions'] = [
      '#type' => 'actions',
    ];

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'image_button',
      //'#value' => $this->t('Search'),
      '#src' => '/themes/custom/athena/images/search.svg',
    ];

    /*
$form['test'] = array(
    '#type' => 'markup',
    '#markup' => "<a class=\"search-courses\" href=\"javascript:void(0)\" onclick=\"document.getElementById('search_insights').submit()\"><img src=\"/themes/custom/athena/images/search.svg\" alt=\"search\"></a>",
  );
  */
  $form['#cache'] = ['max-age' => 0];

    return $form;
  }

  /**
   * Getter method for Form ID.
   *
   * The form ID is used in implementations of hook_form_alter() to allow other
   * modules to alter the render array built by this form controller. It must be
   * unique site wide. It normally starts with the providing module's name.
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
    /*
     * This would normally be replaced by code that actually does something
     * with the title.
     */
    //$title = $form_state->getValue('title');
    //$this->messenger()->addMessage($this->t('You specified a title of %title.', ['%title' => $title]));


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

    $response = Url::fromUserInput($URL.'?searchstring='.$search);
    $form_state->setRedirectUrl($response);
    
    //header("refresh:0");

    //$form_state->setRebuild();
  }

}
