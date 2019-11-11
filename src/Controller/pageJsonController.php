<?php

namespace Drupal\axelerant_assignment\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Access\AccessResult;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class pageJsonController.
 */
class pageJsonController extends ControllerBase {
  
  /**
   * Returns the loaded node in json response
   *
   * @return string
   *   Return Hello string.
   */
  public function pageJson($api_key, NodeInterface $node) {
    $allowed = false;
    $site_api_key = $this->config('system.site')->get('siteapikey');
    
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
