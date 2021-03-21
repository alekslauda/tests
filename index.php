<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use app\Services\Core\OptionsStrategy;
use app\Services\Routing\Exceptions\NotFound;

define('PROJECT_ROOT', __DIR__);

require PROJECT_ROOT . "/defines.php";

require PROJECT_ROOT . "/vendor/autoload.php";


try {
  
  require PROJECT_ROOT . "/services.php";

  $optionsStrategy = new OptionsStrategy(php_sapi_name());
  $optionsStrategy->dispatch();
} catch (NotFound $invalidRouteException) {
  dd($invalidRouteException->getMessage());
} catch (\Exception $ex) {
  dd($ex->getMessage());
}
