<?php

namespace app\Controllers;

use app\Models\Contact\Service;
use app\Models\FileStructure\Service as FileStructureService;
use app\Services\Core\ServiceLocator;
use app\Services\Validation\ContactsValidation;
use app\Services\Validation\Validator;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TestsController extends Controller
{
  protected $service;

  public function solution1()
  {
    $term = $this->getRequest()->get('term', null);
    $data = [];
    if ($term) {
      $data = $this->fileStructureService->fetchAllForTerm($term);
    }
    $this->view->data = $data;
    $this->render();
  }

  public function solution2()
  {
    if ( $this->getRequest()->getMethod() === 'DELETE') {
      $data = json_decode($this->getRequest()->getContent(), true);
      try {

        $this->service->getRepository()->deleteContactByIndex($data['contactId']);
      } catch (\Exception $ex) {
        throw new Exception('ERROR! Contacts could not be deleted.');
      }
      
      $this->completeRequest('You have been successfully deleted a contact.');
    }
    
    if ($this->getRequest()->getMethod() === 'POST') {

      $names = $this->getRequest()->get(ContactsValidation::NAMES, []);
      $emails = $this->getRequest()->get(ContactsValidation::EMAILS, []);
      $phones = $this->getRequest()->get(ContactsValidation::PHONES, []);
      $formsSubmitted = $this->getRequest()->get('forms_submitted', 0);

      $contactsValidation = new ContactsValidation(new Validator());
      $contactsValidation
        ->names($names)
        ->emails($emails)
        ->phones($phones);

      if (!$contactsValidation->validator()->passed()) {
        $response = new JsonResponse(
          ['errors' => $contactsValidation->validator()->errors()], 
          Response::HTTP_UNPROCESSABLE_ENTITY,
        );

        $response->send();
        exit();

      } else {
        try {

          $this->service->bulkInsert([$names, $emails, $phones], $formsSubmitted);
        } catch (\Exception $ex) {
          throw new Exception('ERROR! Contacts could not be created');
        }
        
        $this->completeRequest('You have been successfully created a contact.');
      }
    }

    $this->view->contacts = $this->service->fetchAllAsArray();
    $this->render();
  }

  // public function test1()
  // {
  //   $contacts = [
  //     [
  //       'id' => uniqid(), 
  //     'name' => 'Sasho',
  //     'email' => 'Realert@abv.bg',
  //     'phone' => '123213' 
  //     ],
  //     [
  //       'id' => uniqid(), 
  //     'name' => 'Sasho 1',
  //     'email' => 'Realert1@abv.bg',
  //     'phone' => '1232133' 
  //     ]
  //   ];
  //   file_put_contents(TESTS_FILES . DIRECTORY_SEPARATOR . 'contacts.txt',  '<?php return ' . var_export($contacts, true) . ';');
  //   dd('success');
  // }

  // public function test2()
  // {
  //   $contacts = include TESTS_FILES . DIRECTORY_SEPARATOR . 'contacts.txt';
  //   dd($contacts[1]);
  // }

  protected function init()
  {
    $this->service = ServiceLocator::getInstance()->getService(Service::__ID__);
    $this->fileStructureService = ServiceLocator::getInstance()->getService(FileStructureService::__ID__);
  }

  protected function completeRequest($message)
  {
    $this->getSession()->getFlashBag()->add('success', $message);
    $response = new JsonResponse(
      ['success' => ['redirectTo' => PROJECT_URL . SOLUTION_2]], 
      Response::HTTP_OK,
    );
    $response->send();
    exit();
  }
}
