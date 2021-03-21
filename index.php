<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use app\Services\Core\OptionsStrategy;

define('PROJECT_ROOT', __DIR__);

require PROJECT_ROOT . "/defines.php";

require PROJECT_ROOT . "/vendor/autoload.php";


try {
  
  require PROJECT_ROOT . "/services.php";

  $optionsStrategy = new OptionsStrategy(php_sapi_name());
  $optionsStrategy->dispatch();
} catch (\Exception $ex) {
  dd($ex->getMessage());
}
