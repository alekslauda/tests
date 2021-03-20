<?php

namespace app\Services\Core;

use app\Services\Commands\TreeParserCommand;
use app\Services\Routing\Router;

class OptionsStrategy {
  const CLI_SERVER = 'cli-server';
  const CLI = 'cli';

  protected $option;

  public function __construct($type)
  {
    if (!in_array($type, [self::CLI, self::CLI_SERVER])) {
      throw new \Exception('Invalid app type');
    }

    $this->option = $this->applyStrategy($type);
  }

  protected function applyStrategy($type) {
    $strategies = [
      self::CLI_SERVER => function() {
        return new Router();
      },
      self::CLI => function() {
        return new TreeParserCommand();
      }
    ];

    return $strategies[$type]();
  }

  public function dispatch()
  {
    $this->option->run();
  }
}
