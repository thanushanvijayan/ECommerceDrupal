<?php

namespace Drupal\my_custom_rest\Normalizer;

use Drupal\serialization\Normalizer\ContentEntityNormalizer;
use Drupal\node\NodeInterface;

/**
 * Custom normalizer for node entity.
 */
class CustomNodeNormalizer extends ContentEntityNormalizer {

  /**
   * The interface or class that this Normalizer supports.
   *
   * @var string
   */
  protected $supportedInterfaceOrClass = NodeInterface::class;

  /**
   * {@inheritdoc}
   */
  public function normalize($entity, $format = NULL, array $context = []) {
    $data = parent::normalize($entity, $format, $context);

    $normalizedData = [];

    if (isset($data['field_price'])) {
      $normalizedData['field_price'] = $data['field_price'];
    }

    if (isset($data['field_product_image'])) {
      $image = $data['field_product_image'];

      $normalizedImage = [];
      foreach ($image as $item) {
        $normalizedImage[] = [
          'alt' => $item['alt'],
          'url' => $item['url'],
        ];
      }

      $normalizedData['field_product_image'] = $normalizedImage;
    }

    return $normalizedData;
  }
}
