<?php

namespace app\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use app\Services\Routing\Registry;
use Symfony\Component\HttpFoundation\Session\Session;

abstract class Controller
{

  protected $view;

  private $request;

  private $response;

  private $session;

  public function __construct(
    Registry $registry,
    Request $request,
    Response $response
  ) {
    $this->view = $registry;
    $this->request = $request;
    $this->response = $response;
    $this->session = new Session();
    $this->session->start();
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
    $this->view->template = lcfirst($this->view->controllerName) . DIRECTORY_SEPARATOR . lcfirst($this->view->methodName);
    ob_start();

    include($fileName);

    $obContent = ob_get_contents();
    $this->getResponse()->setContent($obContent);
    ob_end_clean();
  }

  public function renderTemplate($template)
  {
    $templateFileName = VIEW_ROOT . DIRECTORY_SEPARATOR . $template . '.php';

    if (file_exists($templateFileName) == false) {
      throw new \RunTimeException("Invalid filename.{$templateFileName} not found.");
    }

    include($templateFileName);
  }

  public function getRequest()
  {
    return $this->request;
  }

  public function getResponse()
  {
    return $this->response;
  }

  public function getSession()
  {
    return $this->session;
  }
}
