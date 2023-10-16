<?php

namespace Drupal\my_custom_rest\Controller;

use Drupal\Core\Cache\CacheableJsonResponse;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Flood\FloodInterface;
use Drupal\my_custom_rest\Services\CacheService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * The flood service.
   *
   * @var \Drupal\Core\Flood\FloodInterface
   */
  protected $flood;

  /**
   * The custom cache service.
   *
   * @var \Drupal\my_custom_rest\Services\CacheService
   */
  protected $cacheService;

  /**
   * Constructs a CustomRestController object.
   *
   * @param \Symfony\Component\Serializer\SerializerInterface $serializer
   *   The serializer service.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user.
   * @param \Drupal\Core\Flood\FloodInterface $flood
   *   The flood service.
   * @param \Drupal\my_custom_rest\Services\CacheService $cache_service
   *   The custom cache service.
   */
  public function __construct(SerializerInterface $serializer, AccountProxyInterface $current_user, FloodInterface $flood, CacheService $cache_service) {
    $this->serializer = $serializer;
    $this->currentUser = $current_user;
    $this->flood = $flood;
    $this->cacheService = $cache_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('serializer'),
      $container->get('current_user'),
      $container->get('flood'),
      $container->get('my_custom_rest.cache_service')  // Get the custom cache service.
    );
  }

  /**
   * Responds to GET requests.
   *
   * Returns a JSON response with details for a specific node.
   */
  public function get($node_id) {
    $user_id = $this->currentUser->id();

    $this->flood->register('my_rest_resource:' . $user_id, 3600);

    if (!$this->flood->isAllowed('my_rest_resource:' . $user_id, 1000, 3600)) {
        $response_data = ['message' => 'Rate limit exceeded.'];
        return new JsonResponse($response_data, 429);
    }

    $node = Node::load($node_id);

    if ($node) {
      $normalized = $this->serializer->normalize($node, 'json', ['plugin_id' => 'entity:node']);

      $normalized['logged_in_user'] = [
        'uid' => $user_id,
        'username' => $this->currentUser->getAccountName(),
      ];

      $cache_metadata = $this->cacheService->generateCacheMetadata(['session', 'url'], 3600, ['node:' . $node_id]);

      $response = new CacheableJsonResponse($normalized);
      $response->addCacheableDependency($cache_metadata);

      return $response;
    }

    return new JsonResponse(['error' => 'Node not found'], 404);
  }
}
