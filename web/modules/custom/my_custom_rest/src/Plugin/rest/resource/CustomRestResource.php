<?php

namespace Drupal\my_custom_rest\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
 * Provides a Custom Rest Resource
 *
 * @RestResource(
 *   id = "custom_rest_resource",
 *   label = @Translation("Custom Rest Resource"),
 *   uri_paths = {
 *     "canonical" = "/api/custom"
 *   }
 * )
 */
class CustomRestResource extends ResourceBase {

  /**
   * Responds to entity GET requests.
   * Returns a list of bundles for specified entity.
   *
   * @return \Drupal\rest\ResourceResponse
   */
  public function get() {
    $response = ['message' => 'Hello, this is a custom REST endpoint'];
    return new ResourceResponse($response);
  }

  public function post($data) {
    return new ResourceResponse('toto');
  }


}
