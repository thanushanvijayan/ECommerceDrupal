<?php

namespace Drupal\sample_rest_resource\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
 * Provides a REST resource for custom taxonomy terms.
 *
 * @RestResource(
 *   id = "sample_get_rest_resource",
 *   label = @Translation("Sample Get Rest Resource"),
 *   uri_paths = {
 *     "canonical" = "/vb-rest"
 *   }
 * )
 */
class SampleGetRestResource extends ResourceBase {

  /**
   * Responds to GET requests.
   *
   * Returns a list of taxonomy terms.
   */
  public function get() {
    // Fetch taxonomy terms here. For simplicity, returning a static response.
    $response = ['data' => 'Sample response'];

    return new ResourceResponse($response);
  }

}
