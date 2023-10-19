<?php

namespace Drupal\my_custom_rest\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Defines the Item entity.
 *
 * @ContentEntityType(
 *   id = "item",
 *   label = @Translation("Item"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\my_custom_rest\ItemListBuilder",
 *     "form" = {
 *       "add" = "Drupal\my_custom_rest\Form\ItemForm",
 *       "edit" = "Drupal\my_custom_rest\Form\ItemForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "access" = "Drupal\my_custom_rest\Handler\ItemAccessControlHandler",
 *   },
 *   base_table = "item",
 *   admin_permission = "administer item entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *   },
 *   links = {
 *     "canonical" = "/item/{item}",
 *     "edit-form" = "/item/{item}/edit",
 *     "delete-form" = "/item/{item}/delete",
 *     "collection" = "/item",
 *   },
 * )
 */
class Item extends ContentEntityBase {

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Item.'))
      ->setSettings([
        'max_length' => 50,
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

    $fields['price'] = BaseFieldDefinition::create('decimal')
      ->setLabel(t('Price'))
      ->setDescription(t('The price of the Item.'))
      ->setSettings([
        'precision' => 10,
        'scale' => 2,
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'number_decimal',
        'weight' => -3,
      ])
      ->setDisplayOptions('form', [
        'type' => 'number',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->addPropertyConstraints('value', ['Range' => ['min' => 0]]);

    $fields['published_on'] = BaseFieldDefinition::create('datetime')
    ->setLabel(t('Published On'))
    ->setDescription(t('The date and time when the item was published.'))
    ->setSettings([
        'datetime_type' => 'datetime',
    ])
    ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'datetime_default',
        'settings' => [
            'format_type' => 'medium',
        ],
        'weight' => -1,
    ])
    ->setDisplayOptions('form', [
        'type' => 'datetime_default',
        'weight' => -1,
    ])
    ->setDisplayConfigurable('form', TRUE)
    ->setDisplayConfigurable('view', TRUE)
    ->setRequired(TRUE);

    $fields['manufacturer'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Manufacturer'))
      ->setDescription(t('The manufacturer of the item.'))
      ->setSetting('target_type', 'manufacturer')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'entity_reference_label',
        'weight' => -2,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => -2,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    return $fields;
  }

  /**
   * method to calculate the price with tax.
   */
  public function getPriceWithTax() {
    $taxRate = 0.07;
    return $this->price + ($this->price * $taxRate);
  }

  /**
   * method to fetch the manufacturer's name.
   */
  public function getManufacturerName() {
    $manufacturer = $this->manufacturer->entity;
    return $manufacturer ? $manufacturer->name->value : '';
  }

  /**
   * method to get the published date in a specific format.
   */
  public function getFormattedPublishedDate() {
      $publishedDate = $this->get('published_on')->value;
      $date = new \DateTime($publishedDate);
      return $date->format('Y-m-d\TH:i:sO');
  }
}
