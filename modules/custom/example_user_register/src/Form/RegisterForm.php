<?php 
namespace Drupal\register\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class RegisterForm extends FormBase {
	public function getFormId() {
    return 'register_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('Please enter the title and accept the terms of use of the site.'),
    ];

    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Enter Name:'),
      '#required' => TRUE,
    );
    $form['phone'] = array(
      '#type' => 'tel',
      '#title' => t('Enter Contact Number'),
    );
    $form['mail'] = array(
      '#type' => 'email',
      '#title' => t('Enter Email:'),
      '#required' => TRUE,
    );
    $form['age'] = array(
      '#type' => 'select',
      '#title' => t('Select your age:'),
      '#required' => TRUE,
      '#options' => [
        '10-20' => $this->t('10-20'),
        '20-30' => $this->t('20-30'),
        '30-50' => $this->t('30-50'),
      ],
    ); 

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Register'),
      '#button_type' => 'primary',
    );
    return $form;
  }


  public function validateForm(array &$form, FormStateInterface $form_state) {
    
    
    }
  }


// regex for mail : ^\w+\@kyanon.digital$



///we can add the data to database from here
public function submitForm(array &$form, FormStateInterface $form_state) {




  \Drupal::messenger()->addMessage(t("Registration Done!! Registered Values are:"));
  foreach ($form_state->getValues() as $key => $value) {
   \Drupal::messenger()->addMessage($key . ': ' . $value);
 }
}

}