<?php

namespace Drupal\my_custom_rest\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Defines the Manufacturer entity.
 *
 * @ContentEntityType(
 *   id = "manufacturer",
 *   label = @Translation("Manufacturer"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\my_custom_rest\ManufacturerListBuilder",
 *     "form" = {
 *       "add" = "Drupal\my_custom_rest\Form\ManufacturerForm",
 *       "edit" = "Drupal\my_custom_rest\Form\ManufacturerForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "access" = "Drupal\my_custom_rest\Handler\ManufacturerAccessControlHandler",
 *   },
 *   base_table = "manufacturer",
 *   admin_permission = "administer manufacturer entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *   },
 *   links = {
 *     "canonical" = "/manufacturer/{manufacturer}",
 *     "edit-form" = "/manufacturer/{manufacturer}/edit",
 *     "delete-form" = "/manufacturer/{manufacturer}/delete",
 *     "collection" = "/manufacturer",
 *   },
 * )
 */
class Manufacturer extends ContentEntityBase {

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Manufacturer entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['website'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Website'))
      ->setDescription(t('The website of the Manufacturer entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -3,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['email'] = BaseFieldDefinition::create('email')
      ->setLabel(t('Email'))
      ->setDescription(t('The email of the Manufacturer entity.'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'email_mailto',
        'weight' => -2,
      ])
      ->setDisplayOptions('form', [
        'type' => 'email_default',
        'weight' => -2,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    return $fields;
  }

  /**
   * Method to get the manufacturer's contact information as a single string.
   */
  public function getContactInfo() {
    return $this->email . '; ' . $this->website;
  }

}
