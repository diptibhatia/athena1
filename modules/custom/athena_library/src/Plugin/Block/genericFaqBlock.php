<?php

namespace Drupal\athena_library\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\node\Entity\Node;


/**
 * Provides a 'Generic FAQ' block.
 *
 * @Block(
 *   id = "custom_generic_faq_block",
 *   admin_label = @Translation("Generic FAQ")
 * )
 */
class genericFaqBlock extends BlockBase {
  
  /**
   * {@inheritdoc}
   *
   * The return value of the build() method is a renderable array. Returning an
   * empty array will result in empty block contents. The front end will not
   * display empty blocks.
   */
  public function build() {
    $bundle = 'generic_faq';
    $faqquery = \Drupal::entityQuery('node');
    $faqquery->condition('status', 1);
    $faqquery->condition('type', $bundle);
    $faq_nodes = $faqquery->execute();
    $nid = 0;
    if(!empty($faq_nodes)) {
      $temp = array_values($faq_nodes);
      $nid = $temp[0];
    }
    
    $node = Node::load($nid);
    $paragraph_faq = $node->field_gen_faq_que_ans->referencedEntities();
    $faq = [];
    foreach($paragraph_faq as $key => $val) {
      $faq_cat_id = $val->get('field_faq_cat')->target_id;
      $faq_cat_name = $val->get('field_faq_cat')->entity->getName();
      $qans = $val->field_gen_question_answer->referencedEntities();
        foreach($qans as $questionsnum => $qa) {
            $faq[$faq_cat_name][] =  [
            'question' =>  $qa->get('field_general_question')->value, 
            'answer' => $qa->get('field_general_answer')->value];
        }
    }
    return [
      '#faqs' => $faq,
      '#title' => 'Frequently Asked Questions',
      '#theme' => 'custom_generic_faq_block',
      '#cache' => [
        'max-age' => 0,
      ]
    ];
  }

  public function getCacheMaxAge() {
    return 0;
  }
}
