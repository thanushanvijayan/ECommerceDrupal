<?php

namespace Drupal\Tests\my_custom_rest\Unit;

use Drupal\my_custom_rest\Controller\CustomRestController;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Flood\FloodInterface;
use Drupal\my_custom_rest\Services\CacheService;
use Symfony\Component\Serializer\SerializerInterface;
use Drupal\Tests\UnitTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;
use Prophecy\Argument;

/**
 * @coversDefaultClass \Drupal\my_custom_rest\Controller\CustomRestController
 * @group my_custom_rest
 */
class CustomRestControllerTest extends UnitTestCase {

  /**
   * The custom rest controller.
   *
   * @var \Drupal\my_custom_rest\Controller\CustomRestController
   */
  protected $customRestController;

  /**
   * The mock serializer.
   *
   * @var \Symfony\Component\Serializer\SerializerInterface|\Prophecy\Prophecy\ObjectProphecy
   */
  protected $serializer;

  /**
   * The mock current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface|\Prophecy\Prophecy\ObjectProphecy
   */
  protected $currentUser;

  /**
   * The mock flood service.
   *
   * @var \Drupal\Core\Flood\FloodInterface|\Prophecy\Prophecy\ObjectProphecy
   */
  protected $flood;

  /**
   * The mock cache service.
   *
   * @var \Drupal\my_custom_rest\Services\CacheService|\Prophecy\Prophecy\ObjectProphecy
   */
  protected $cacheService;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $this->serializer = $this->prophesize(SerializerInterface::class);
    $this->currentUser = $this->prophesize(AccountProxyInterface::class);
    $this->flood = $this->prophesize(FloodInterface::class);
    $this->cacheService = $this->prophesize(CacheService::class);

    $this->customRestController = new CustomRestController(
      $this->serializer->reveal(),
      $this->currentUser->reveal(),
      $this->flood->reveal(),
      $this->cacheService->reveal()
    );
  }

  /**
   * Tests the response for node not found.
   */
  public function testGetNodeNotFound() {
    $node_id = 123;

    $this->serializer->normalize(Argument::cetera())->shouldNotBeCalled();

    $response = $this->customRestController->get($node_id);

    $this->assertInstanceOf(JsonResponse::class, $response);
    $this->assertEquals(404, $response->getStatusCode());
  }

  /**
   * Tests the response for a successful node load.
   */
  public function testGetSuccessful() {
    $node_id = 123;

    $node = $this->prophesize(Node::class);
    $node->id()->willReturn($node_id);

    Node::load($node_id)->willReturn($node->reveal());

    $this->serializer->normalize(Argument::cetera())->willReturn(['some' => 'data']);

    $response = $this->customRestController->get($node_id);

    $this->assertInstanceOf(JsonResponse::class, $response);
    $this->assertEquals(200, $response->getStatusCode());
  }
}
