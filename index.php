<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use app\Services\Core\OptionsStrategy;
use app\Services\Routing\Exceptions\NotFound;
use app\Services\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;

require __DIR__."/defines.php";

require __DIR__."/vendor/autoload.php";

// dd(getopt(':S'));
try {
  $optionsStrategy = new OptionsStrategy(php_sapi_name());
  $optionsStrategy->dispatch();
} catch (NotFound $invalidRouteException) {
  dd($invalidRouteException->getMessage());
  // $response = new RedirectResponse(PROJECT_URL)
} catch (\Exception $ex) {
  // $response->setContent($ex->getMessage());
  dd($ex->getMessage());
}
