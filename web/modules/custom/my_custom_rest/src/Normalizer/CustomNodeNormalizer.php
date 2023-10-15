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
    // Normalize the entire node first.
    $data = parent::normalize($entity, $format, $context);

    // Prepare the array for the fields you want to include.
    $normalizedData = [];

    // Add the 'field_price' to the response if it exists in the node.
    if (isset($data['field_price'])) {
      $normalizedData['field_price'] = $data['field_price'];
    }

    // Normalize the 'field_product_image' field.
    if (isset($data['field_product_image'])) {
      // You can manipulate the data here before adding it to the response.
      // For example, you might want to change the structure, combine fields, etc.
      $image = $data['field_product_image'];

      // Let's say you want to keep only the 'alt' text and 'url' from the image field data.
      $normalizedImage = [];
      foreach ($image as $item) {
        $normalizedImage[] = [
          'alt' => $item['alt'],
          'url' => $item['url'],
        ];
      }

      $normalizedData['field_product_image'] = $normalizedImage;
    }

    // Return the modified data.
    return $normalizedData;
  }
}
