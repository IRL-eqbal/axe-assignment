<?php

namespace Drupal\axelerant_assignment\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Class pageJsonController.
 */
class pageJsonController extends ControllerBase {
  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;
	
	/**
   * Constructs a new CalculteCityRoutesdistanceForm object.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }
	
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }
	/**
	 * Calculate and return sortest path between two cities.
   *
	 * @param string $api_key
	 *   API Key from system config.
	 *
	 * @param int $nid
	 *   Node ID as route parameters
	 *
	 * @return
	 *  Return node in form of json Object.
	 *
	 */
  public function pageJson($api_key, $nid) {
		$allowed = false;
		$site_api_key = $this->config('system.site')->get('siteapikey');
		$node = $this->entityTypeManager->getStorage('node')->load($nid);
		
		if ($node->getType() == 'page' && $api_key == $site_api_key) {
			$allowed = true;
		}
		
		if ($allowed) {
			return new JsonResponse($node->toArray(), 200, ['Content-Type' => 'application/json']);
		}
		else{
			return new JsonResponse(["error" => "access denied"], 401, ['Content-Type' => 'application/json']);
		}
	}
}
