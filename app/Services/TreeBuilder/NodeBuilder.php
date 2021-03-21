<?php

namespace app\Services\TreeBuilder;

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
