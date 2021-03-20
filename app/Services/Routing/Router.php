<?php

namespace app\Services\Routing;

use app\Services\Core\OptionsStrategyInterface;
use app\Services\Routing\Exceptions\NotFound;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router implements OptionsStrategyInterface {

  const CONTROLLERS_NAMESPACE = '\\app\\Controllers\\';

  protected $request;
  protected $response;

  public function __construct()
  {
    $this->request = Request::createFromGlobals();
    $this->response = new Response();
    
    if ($this->request->getSchemeAndHttpHost() !== PROJECT_URL) {
      exit(
        sprintf("
            Project is set up to work on %s.
            Please serve the app with: <b>php -S localhost:8000</b>
          ", 
          PROJECT_URL
        )
      );
      
    }
  }

  public function run()
  {
    $queryParams = array_filter(explode('/', $this->request->getPathInfo()));
    $controllerName = 'Index';
    $methodName = 'index';

    if (isset($queryParams[1])) {
      $controllerName = ucfirst($queryParams[1]);
    }

    if (isset($queryParams[2])) {
      $methodName = ucfirst($queryParams[2]);
    }

    $registry = new Registry();
    $registry->controllerName = $controllerName;
    $registry->methodName = $methodName;

    $controllerClassName = self::CONTROLLERS_NAMESPACE . $controllerName . 'Controller';
    
    if (!method_exists($controllerClassName, $methodName)) {
      throw new NotFound('Page not found');
    }

    $controller = new $controllerClassName($registry, $this->request, $this->response);
    $controller->$methodName();

    $this->response->send();
    exit();
  }
}
