<?php

namespace app\Services\Commands;

use app\Services\Core\OptionsStrategyInterface;

interface NodeBuilderInterface {

}

class Node  {
  protected $title;
  protected $parent;
  protected $child;

  public function __construct($title)
  {
    $this->title = $title;
    $this->parent = null;
    $this->children = [];
  }

  public function add($child)
  {
    $this->children[] = $child;
    $child->parent = $this;
  }

  public function getParent()
  {
    return $this->parent;
  }

  public function getChildren()
  {
    return $this->children;
  }

  public function getTitle()
  {
    return $this->title;
  }
}

class NodeBuilder implements NodeBuilderInterface {
  
  public function __construct(Node $node, $depth = 0)
  {
    $this->node = $node;
    $this->depth = $depth;
  }

  public function __invoke($title, $depth)
  {
    $newNode = new Node($title);

    if ($depth > $this->depth) {
      $this->node->add($newNode);
      $this->depth = $depth;
    } else if ($depth === $this->depth) {
      $this->node->getParent()->add($newNode);
    } else {
      $parent = $this->node->getParent();

      foreach (range(1, $this->depth - $depth) as $x) {
        $parent = $parent->getParent();
      }
      $parent->add($newNode);
      $this->depth = $depth;
    }

    $this->node = $newNode;
  }

  public function setTree(Node $tree)
  {
    $this->node = $tree;
  }

  public function getTree()
  {
    return $this->node;
  }
}

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
    
    dd($this->prepareForInsert($builder->getTree()));
  }

  public function prepareForInsert(Node $tree, &$paths =[], $path = '')
  {
    $path .= DIRECTORY_SEPARATOR . $tree->getTitle();
    foreach ($tree->getChildren() as $child) {
      $paths[] = $path . DIRECTORY_SEPARATOR . $child->getTitle();
      $this->prepareForInsert($child, $paths, $path);
    }
    return $paths;
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

  public function run()
  {
    dd('here');
  }
}
