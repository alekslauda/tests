<?php

namespace app\Models\Contact;

class Factory {

  public function create(array $data)
  {
      return new ContactEntity($data['id'], $data['name'], $data['email'], $data['phone']);
  }
}
