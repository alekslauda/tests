<?php
namespace app\Models\Contact;

class ContactEntity {

  protected $id;
  protected $name;
  protected $email;
  protected $phone;

  public function __construct($id, $name, $email, $phone)
  {
    $this->id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->phone = $phone;
  }

  public function getId() {
    return $this->id;
  }

  public function getEmail() {
    return $this->email;
  }

  public function getName() {
    return $this->name;
  }

  public function getPhone() {
    return $this->phone;
  }
}
