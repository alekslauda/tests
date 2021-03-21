<?php

namespace app\Models\FileStructure;

use app\Services\Core\ServiceInterface;
use app\Services\TreeBuilder\Node;

class Service implements ServiceInterface {
  const __ID__ = 'file.tree_structure.service';

  protected $repository;

  public function __construct(Repository $repository)
  {
    $this->repository = $repository;
  }

  public function getID()
  {
    return self::__ID__;
  }

  public function getRepository()
  {
    return $this->repository;
  }

  public function fetchAllForTerm($term)
  {
      return $this->repository->fetchAllForTerm($term);
  }

  public function parseTree(Node $tree, &$paths =[], $path = '')
  {
    $path .= DIRECTORY_SEPARATOR . $tree->getTitle();
    foreach ($tree->getChildren() as $child) {
      $paths[] = $path . DIRECTORY_SEPARATOR . $child->getTitle();
      $this->parseTree($child, $paths, $path);
    }
    return $paths;
  }
}
