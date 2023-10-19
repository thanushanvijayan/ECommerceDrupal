<?php

namespace Drupal\my_custom_rest;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Defines a class to build a listing of Manufacturer entities.
 */
class ManufacturerListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Manufacturer ID');
    $header['name'] = $this->t('Name');
    $header['website'] = $this->t('Website');
    $header['email'] = $this->t('Email');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\my_custom_rest\Entity\Manufacturer */
    $row['id'] = $entity->id();
    $row['name'] = $entity->link();
    $row['website'] = $entity->website->value;
    $row['email'] = $entity->email->value;
    return $row + parent::buildRow($entity);
  }

}
