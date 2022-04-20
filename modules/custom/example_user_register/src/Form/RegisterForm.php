<?php 
namespace Drupal\register\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class RegisterForm extends FormBase {
	public function getFormId() {
    return 'register_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Enter Name:'),
      '#required' => TRUE,
    );
    $form['phone'] = array(
      '#type' => 'tel',
      '#title' => t('Enter Contact Number:'),
      '#required' => TRUE,
    );
    $form['mail'] = array(
      '#type' => 'email',
      '#title' => t('Enter Email:'),
    );
    $form['age'] = array(
      '#type' => 'select',
      '#title' => t('Select your age:'),
      '#options' => [
        '10-20' => [
            '10-17' => $this->t('10-17'),
            '18-20' =>  $this->t('18-20'),
        ],
        '20-30' => $this->t('20-30'),
        '30-50' => $this->t('30-50'),
      ],
      '#default' => '10-20',
    );

    $form['descript'] = array(
      '#type' => 'textarea',
      '#title' => $this
        ->t('Describe yourself:'),
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

    $pattern = '/^[a-zA-Z]+(?:\s[a-zA-Z]+)+$/';
    $subject = $form_state->getValue('name');
    if(!preg_match($pattern, $subject, $matches)) {
      $form_state->setErrorByName('name', $this->t('Use your full real name, please'));
    }

    $pattern = '/((09|03|07|08|05|01)+([0-9]{8,9})\b)/';
    $subject = $form_state->getValue('phone');
    if(!preg_match($pattern, $subject, $matches)) {
      $form_state->setErrorByName('phone', $this->t('Enter a valid vietnamese number'));
    }

    $pattern = '/^\w+\@kyanon.digital$/';
    $subject = $form_state->getValue('mail');
    if (!preg_match($pattern, $subject, $matches)){
      $form_state->setErrorByName('mail', $this->t('Your mail must in @kyanon.digital'));
    }

    if ($form_state->getValue('age') == '10-17'){
      $form_state->setErrorByName('age', $this->t('Your age is under 18, go tell your mom to get registration for you!'));
    }
  } 

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $field = $form_state->getValues();
    $name = $field['name'];
    $phone = $field['phone'];
    $mail = $field['mail'];
    $age = $field['age'];
    $descript = $field['descript'];

    $field = [
      'name'   => $name,
      'phone'   => $phone,
      'mail'   => $mail,
      'age'   => $age,
      'descript'   => $descript,
    ];
    
    $query = db_insert('kyanon_register')
      ->fields($field)
      ->execute();

    drupal_set_message("Your infomation are succesfully created");

   //  $form_state->setRedirect('register.register_form');

    // \Drupal::messenger()->addMessage(t("Registration Done!! Registered Values are:"));
    // foreach ($form_state->getValues() as $key => $value) {
    //  \Drupal::messenger()->addMessage($key . ': ' . $value);
    // }
 }

}