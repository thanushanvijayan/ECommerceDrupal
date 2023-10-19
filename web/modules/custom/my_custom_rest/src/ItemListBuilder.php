<?php

namespace Drupal\my_custom_rest;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Defines a class to build a listing of Item entities.
 */
class ItemListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['name'] = $this->t('Name');
    $header['price'] = $this->t('Price');
    $header['manufacturer'] = $this->t('Manufacturer');
    $header['published_on'] = $this->t('Published On');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\my_custom_rest\Entity\Item */
    $row['name'] = $entity->label();
    $row['price'] = number_format((float) $entity->get('price')->value, 2, '.', '');  // Format the price to 2 decimal places
    $row['manufacturer'] = $entity->getManufacturerName();  // Assumes the method is correctly retrieving the manufacturer's name
    $row['published_on'] = $entity->getFormattedPublishedDate();  // Assumes the method is correctly formatting the date

    return $row + parent::buildRow($entity);
  }

}
