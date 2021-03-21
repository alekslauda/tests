<?php

namespace app\Models\Contact;

class Repository {

  const CONTACTS_STORAGE_FILE = TESTS_FILES . '/contacts.txt';

  protected $factory;

  public function __construct(Factory $factory)
  {
    $this->factory = $factory; 
  }

  public function getFactory()
  {
    return $this->factory;
  }

  public function fetchAll()
  {
    if (file_exists(self::CONTACTS_STORAGE_FILE)) {
      return include self::CONTACTS_STORAGE_FILE;
    }
    return [];
  }

  public function insert($contacts)
  {
    file_put_contents(self::CONTACTS_STORAGE_FILE,  '<?php return ' . var_export($contacts, true) . ';');
  }

  public function deleteContactByIndex($index)
  {
    $data = $this->fetchAll();

    if (count($data) === 1) {
      unlink(self::CONTACTS_STORAGE_FILE);
    } else {
      array_splice($data, $index, 1);

      $this->insert($data);
    }

  }

  public function bulkInsert($contacts)
  {
    $data = array_merge($this->fetchAll(), $contacts);
    $this->insert($data);
  }
}
