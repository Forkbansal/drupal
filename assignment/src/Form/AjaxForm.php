<?php

namespace Drupal\assignment\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
class AjaxForm extends FormBase {

  public function getFormId() {
    return 'ajax_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['number_1'] = array(
      '#type' => 'textfield',
      '#title' => t('Enter the First Number:'),
      '#required' => TRUE,
    );
    $form['number_2'] = array(
      '#type' => 'textfield',
      '#title' => t('Enter the Second Number'),
      '#required' => TRUE,
    );
    
    $form['operation'] = array (
      '#type' => 'radios',
      '#title' => ('Select Operation'),
      '#ajax' =>[
        'callback'=> '::setMessage',
        'event' => 'change',
        'wrapper' => 'result-output',
        'type' => 'throbber',  
      ],
      '#options' => array(
        'Add' =>t('Add'),
        'Subtract' =>t('Subtract'),
        'Multiply' =>t('Multiply'),
        'Division' =>t('Divide')
      ),
    );
    
    $form['output'] = [
        '#type' => 'markup',
        '#markup' => '<div id="result-output"></div>',
    ];
    
    return $form;
  }

  public function setMessage(array $form, FormStateInterface $form_state){
    $operationselected = $form_state -> getValue('operation');
    $number_1 = $form_state -> getValue('number_1');
    $number_2 = $form_state -> getValue('number_2');

    switch($operationselected){
        case 'Add':
          $result = $number_1 + $number_2;
            break;
        case 'Subtract':
          $result = $number_1 - $number_2;
          break;
        case 'Multiply':
          $result = $number_1 * $number_2;
          break;
          case 'Division':
          $result = $number_1 / $number_2;
          break;
    }

    $ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new HtmlCommand('#result-output', 'The output is:' .$result));
    return $ajax_response;
  }

  public function submitForm(array &$form, FormStateInterface $form_state){
    
}
}
 
