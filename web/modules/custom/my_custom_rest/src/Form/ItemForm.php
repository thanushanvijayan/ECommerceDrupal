<?php

namespace Drupal\my_custom_rest\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the Item entity edit forms.
 */
class ItemForm extends ContentEntityForm {

  /**
   * Builds the form used for Item entity edit forms.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * Form validation handler for the Item edit form.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    $price = $form_state->getValue('price');
    if ($price < 0) {
      $form_state->setErrorByName('price', $this->t('The price cannot be negative.'));
    }
  }

  /**
   * Form submission handler for the Item edit form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
  }

  /**
   * Form save handler for the Item edit form.
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $status = parent::save($form, $form_state);

    $message = $status == SAVED_NEW
      ? $this->t('Created the %label Item.', ['%label' => $entity->label()])
      : $this->t('Saved the %label Item.', ['%label' => $entity->label()]);

    $this->messenger()->addMessage($message);

    $form_state->setRedirect('entity.item.canonical', ['item' => $entity->id()]);
  }

}
