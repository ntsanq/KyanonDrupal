<?php 
namespace Drupal\register\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use \Drupal\Core\Database\Connection;
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

    $pattern = '/(^[A-Za-z]{1,16})([ ]{0,1})([A-Za-z]{1,16})?([ ]{0,1})?([A-Za-z]{1,16})?([ ]{0,1})?([A-Za-z]{1,16})/';
    $subject = $form_state->getValue('name');
    if(!preg_match($pattern, $subject, $matches)) {
      $form_state->setErrorByName('name', $this->t('Use your real name, OK?'));
    }

    $pattern = '/((09|03|07|08|05|01)+([0-9]{8,9})\b)/';
    $subject = $form_state->getValue('phone');
    if(!preg_match($pattern, $subject, $matches)) {
      $form_state->setErrorByName('phone', $this->t('Please enter a valid vietnamese number'));
    }

    $pattern = '/^\w+\@kyanon.digital$/';
    $subject = $form_state->getValue('mail');
    if (!preg_match($pattern, $subject, $matches)){
      $form_state->setErrorByName('mail', $this->t('Your mail must in @kyanon.digital'));
    }
  }


// regex for mail : ^\w+\@kyanon.digital$



///we can add the data to database from here
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $field = $form_state->getValues();
    $name = $field['name'];
    $phone = $field['phone'];
    $mail = $field['mail'];
    $age = $field['age'];

    $field = [
      'name'   => $name,
      'phone'   => $phone,
      'mail'   => $mail,
      'age'   => $age,
    ];

    // $conn = Database::getConnection();
    // $query = \Drupal::database();
    
    $query = db_insert('kyanon_register')
      ->fields($field)
      ->execute();

    drupal_set_message("Succesfully updated");

   //  $form_state->setRedirect('register.register_form');

   //  \Drupal::messenger()->addMessage(t("Registration Done!! Registered Values are:"));
   //  foreach ($form_state->getValues() as $key => $value) {
   //   \Drupal::messenger()->addMessage($key . ': ' . $value);
   // }
 }

}