<?php

namespace Drupal\my_custom_rest\Access;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;

/**
 * Custom access check.
 */
class CustomAccessCheck implements AccessInterface {

  /**
   * A custom access check method.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Run access checks for this account.
   */
  public function access(AccountInterface $account) {
    $user = \Drupal\user\Entity\User::load($account->id());

    if ($user->hasRole('administrator')) {
      return AccessResult::allowed();
    }

    return AccessResult::forbidden('You do not have the necessary permissions to access this page.');
  }
}
