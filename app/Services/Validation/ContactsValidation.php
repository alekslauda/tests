<?php

namespace app\Services\Validation;

class ContactsValidation {

  const NAMES = 'names';
  const PHONES = 'phones';
  const EMAILS = 'emails';

  protected $validator;
  public function __construct(Validator $validator)
  {
    $this->validator = $validator;
  }

  protected function validate($data, $field)
  {
    foreach ($data as $form => $val) {
      
      $this->validator
        ->name(sprintf('%s.%s', $field, $form))
        ->value($val)
        ->required()
        ->pattern(Regex::NAME_REGEX);
    }
  }

  public function names($names) {
    $this->validate($names, self::NAMES);
    return $this;
  }

  public function phones($phones) {
    $this->validate($phones, self::PHONES);
    return $this;

  }

  public function emails($emails) {
    $this->validate($emails, self::EMAILS);
    return $this;
  }

  public function validator()
  {
    return $this->validator;
  }

  
}
