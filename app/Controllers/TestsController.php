<?php

namespace app\Controllers;

use app\Services\Validation\ContactsValidation;
use app\Services\Validation\Regex;
use app\Services\Validation\Validator;

class TestsController extends Controller
{
  public function solution1()
  {
    $this->view->title = 'Solution 1';
    $this->render();
  }
  
  public function solution2()
  {
    var_dump($this->getSession()->get('errors'));
    if ($this->getRequest()->getMethod() === 'POST') {
      $names = $this->getRequest()->get(ContactsValidation::NAMES, []);
      $emails = $this->getRequest()->get(ContactsValidation::EMAILS, []);
      $phones = $this->getRequest()->get(ContactsValidation::PHONES, []);
      
      $contactsValidation = new ContactsValidation(new Validator());
      $contactsValidation
        ->names($names)
        ->emails($emails)
        ->phones($phones);

      if (!$contactsValidation->validator()->passed()) {
        $this->getSession()->set('errors', $contactsValidation->validator()->errors());
      } else {
        $this->getSession()->clear();
      }
    }
    $this->render();
  }
}
