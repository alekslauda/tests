<?php

namespace app\Services\TreeBuilder;

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
