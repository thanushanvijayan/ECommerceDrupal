<?php

namespace Drupal\my_custom_rest\Handler;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Manufacturer entity.
 */
class ManufacturerAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view manufacturer entity');

      case 'edit':
        return AccessResult::allowedIfHasPermission($account, 'edit manufacturer entity');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete manufacturer entity');
    }

    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add manufacturer entity');
  }
}
