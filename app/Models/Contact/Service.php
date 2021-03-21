<?php

namespace app\Models\Contact;
use app\Services\Core\ServiceInterface;

class Service implements ServiceInterface {
  const __ID__ = 'file.contacts.service';

  protected $repository;

  public function __construct(Repository $repository)
  {
    $this->repository = $repository;
  }

  public function getID()
  {
    return self::__ID__;
  }

  public function fetchAll()
  {
    $data = $this->repository->fetchAll();
    $contacts = [];
    foreach ($data as $row) {
      $contacts[] = $this->repository->getFactory()->create($row);
    }

    return $contacts;
  }

  public function fetchAllAsArray()
  {
    return $this->repository->fetchAll(); 
  }

  public function bulkInsert($data, $formsSubmitted)
  {
    $contacts = [];
    for ($i = 0; $i < $formsSubmitted; $i++) {
      $contacts[] = [
        'id' => uniqid(),
        'name' => $data[0][$i],
        'email' => $data[1][$i],
        'phone' => $data[2][$i]
      ];
    }

    $this->getRepository()->bulkInsert($contacts);
  }

  public function getRepository()
  {
    return $this->repository;
  }
}
