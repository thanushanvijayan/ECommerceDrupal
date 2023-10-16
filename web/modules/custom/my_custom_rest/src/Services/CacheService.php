<?php

namespace Drupal\my_custom_rest\Services;

use Drupal\Core\Cache\CacheableMetadata;

/**
 * Defines a service for handling cache-related functionalities.
 */
class CacheService {

  /**
   * Generates cache metadata for responses.
   *
   * @param array $contexts
   *   The cache contexts.
   * @param int $max_age
   *   The maximum age for the cache.
   * @param array $tags
   *   The cache tags.
   *
   * @return \Drupal\Core\Cache\CacheableMetadata
   *   The cache metadata.
   */
  public function generateCacheMetadata(array $contexts, $max_age, array $tags) {
    $cache_metadata = new CacheableMetadata();
    $cache_metadata->setCacheContexts($contexts);
    $cache_metadata->setCacheMaxAge($max_age);
    $cache_metadata->setCacheTags($tags);

    return $cache_metadata;
  }
}
