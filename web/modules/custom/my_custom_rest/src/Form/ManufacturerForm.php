<?php

namespace Drupal\my_custom_rest\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the Manufacturer entity edit forms.
 */
class ManufacturerForm extends ContentEntityForm {

  /**
   * Builds the form used for Manufacturer entity edit forms.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    $form['custom_message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Custom Message'),
      '#description' => $this->t('This message will not be saved with the entity.'),
      '#rows' => 4,
    ];

    return $form;
  }

  /**
   * Form validation handler for the Manufacturer edit form.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    $customMessage = $form_state->getValue('custom_message');
    if (trim($customMessage) === '') {
      $form_state->setErrorByName('custom_message', $this->t('Please fill in the custom message.'));
    }
  }

  /**
   * Form submission handler for the Manufacturer edit form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
  }

  /**
   * Form save handler for the Manufacturer edit form.
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $status = parent::save($form, $form_state);

    $message = $status == SAVED_NEW
      ? $this->t('Created the %label Manufacturer.', ['%label' => $entity->label()])
      : $this->t('Saved the %label Manufacturer.', ['%label' => $entity->label()]);

    $this->messenger()->addMessage($message);

    $form_state->setRedirect('entity.manufacturer.canonical', ['manufacturer' => $entity->id()]);
  }

}
