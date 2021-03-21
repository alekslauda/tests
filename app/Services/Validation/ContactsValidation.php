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

  // could be opptimised with polymorphism
  protected function validate($data, $field, $rules = [], $errorMsg = '')
  {
    $defaultRule[] = 'required';
    if ($rules) {
      $rules = array_merge($defaultRule, $rules);
    }
    foreach ($data as $form => $val) {
      
      $this->validator
        ->name(sprintf('%s.%s', $field, $form))
        ->value($val);
        foreach ($rules as $arg) {
          
          $rule = explode('|', $arg);
          $params = [];
          if (count($rule) > 1) {
            $params[] = $rule[1];
            $params[] = $errorMsg;
          }
          call_user_func_array(array($this->validator, $rule[0]), $params);
        }
    }
  }

  
  public function names($names) {
    $this->validate($names, self::NAMES, ['pattern|' . Regex::NAME_REGEX]);
    return $this;
  }

  public function phones($phones) {
    $this->validate(
      $phones, 
      self::PHONES, 
      ['pattern|' . Regex::PHONE_NUMBER_REGEX],
      'is invalid phone number.'
    );
    return $this;

  }

  public function emails($emails) {
    $this->validate(
      $emails, 
      self::EMAILS, 
      ['pattern|' . Regex::EMAIL_PATTERN_REGEX],
      'is invalid email.'
    );
    return $this;
  }

  public function validator()
  {
    return $this->validator;
  }

  
}
