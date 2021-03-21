<?php

namespace app\Controllers;


class IndexController extends Controller
{
  public function index()
  {
    $this->view->title = 'Hello, check my solutions';
    $this->render();
  }

  protected function init()
  {
    //
  }
}
