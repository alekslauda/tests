<?php

namespace app\Controllers;


class PageNotFoundController extends Controller
{
  public function index()
  {
    $this->view->message = 'The page you are looking for was not found.';
    $this->render();
  }

  protected function init()
  {
    //
  }

  public function render()
  {
    $fileName = VIEW_ROOT . DIRECTORY_SEPARATOR .  'base.php';
    if (file_exists($fileName) == false) {
      throw new \RunTimeException("Invalid filename.{$fileName} not found.");
    }
    $viewData = $this->view->getData();
    foreach ($viewData as $varName => $value) {
      $$varName = $value;
    }
    
    $this->view->template = DIRECTORY_SEPARATOR . '404/index';

    ob_start();

    include($fileName);

    $obContent = ob_get_contents();
    $this->getResponse()->setContent($obContent);
    ob_end_clean();
  }
}
