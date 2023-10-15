<?php

namespace Drupal\my_custom_rest\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Defines CustomRestController class.
 */
class CustomRestController extends ControllerBase {

  /**
   * The serializer service.
   *
   * @var \Symfony\Component\Serializer\SerializerInterface
   */
  protected $serializer;

  /**
   * Constructs a CustomRestController object.
   *
   * @param \Symfony\Component\Serializer\SerializerInterface $serializer
   *   The serializer service.
   */
  public function __construct(SerializerInterface $serializer) {
    $this->serializer = $serializer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('serializer')
    );
  }

  /**
   * Responds to GET requests.
   *
   * Returns a JSON response with details for a specific node.
   */
  public function get($node_id) {
    // Load the node entity.
    $node = Node::load($node_id);

    if ($node) {
      // If the node entity is found, normalize it.
      $normalized = $this->serializer->normalize($node, 'json', ['plugin_id' => 'entity:node']);

      return new JsonResponse($normalized);
    }

    // If there was no entity, return a standard "not found" response.
    return new JsonResponse(['error' => 'Node not found'], 404);
  }
}
