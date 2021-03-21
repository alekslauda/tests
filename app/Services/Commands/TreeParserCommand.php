<?php

namespace app\Services\Commands;

use app\Models\FileStructure\Service;
use app\Services\Core\OptionsStrategyInterface;
use app\Services\Core\ServiceLocator;
use app\Services\TreeBuilder\Node;
use app\Services\TreeBuilder\NodeBuilder;

class TreeParserCommand implements OptionsStrategyInterface
{

  const TREE_STRUCTURE_FILE = TESTS_FILES . DIRECTORY_SEPARATOR . 'file_structure.txt';

  public function __construct()
  {
    try {
      $this->contents = @file($this->getFilepath(), FILE_IGNORE_NEW_LINES);
    } catch (\Exception $ex) {
      exit(sprintf(
        '%s.' . PHP_EOL . PHP_EOL .
          'Please provide a valid file or check your command execution.
          Command usage: ' . PHP_EOL . PHP_EOL .
          '%s' . PHP_EOL .
          '%s' . PHP_EOL . PHP_EOL,
        $ex->getMessage(),
        'php index.php --path="Path/To/My/File.txt"',
        'php index.php "Path/To/My/File.txt"'
      ));
    }

    if (!$this->contents) {
      exit('File is emtpy.');
    }

    $tree = new Node($this->contents[0]);
    $builder = new NodeBuilder($tree);

    foreach ($this->contents as $line => $content) {
      if ($line === 0) {
        continue;
      }
      $tabs = strspn($content, "\t");
      $builder(trim($content), $tabs);
    }
    $builder->setTree($tree);

    $this->treeBuilder = $builder;
  }

  public function run()
  {
    $service = ServiceLocator::getInstance()->getService(Service::__ID__);
    $dbData = $service->parseTree($this->treeBuilder->getTree());
    $inserted = $service->getRepository()->bulkInsert($dbData);

    echo sprintf('SUCCESSFULLY INSERTED: %s TREE NODES', $inserted);
  }

  protected function getFilepath()
  {
    global $argv;

    $params = getopt(null, ['path:']);

    $filepath = self::TREE_STRUCTURE_FILE;

    if (isset($params['path'])) {
      $filepath = $params['path'];
    } else if (isset($argv[1])) {
      $filepath = $argv[1];
    }
    

    if (!file_exists($filepath)) {
      throw new \Exception('File not exists');
    }

    return $filepath;
  }
}
