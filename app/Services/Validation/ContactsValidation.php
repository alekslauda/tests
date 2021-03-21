<?php

namespace app\Services\Validation;

class ContactsValidation extends Validator {

  const NAMES = 'names';
  const PHONES = 'phones';
  const EMAILS = 'emails';

  protected function validate($data, $field, $rules = [])
  {
    foreach ($data as $form => $val) {
      
      $this
        ->name(sprintf('%s.%s', $field, $form))
        ->value($val);
        foreach (array_merge(['required'], $rules) as $arg) {
          
          $rule = explode('|', $arg);
          $params = [];
          
          if (count($rule) > 1) {
            array_push($params, $rule[1]);
          }
          call_user_func_array(array('parent', $rule[0]), $params);
        }
    }
  }

  
  public function names($names) {
    $this->validate(
      $names, 
      self::NAMES, 
      ['pattern|' . Regex::NAME_REGEX],
    );
    return $this;
  }

  public function phones($phones) {
    $this->validate(
      $phones, 
      self::PHONES, 
      ['pattern|' . Regex::PHONE_NUMBER_REGEX],
    );
    return $this;

  }

  public function emails($emails) {
    $this->validate(
      $emails, 
      self::EMAILS, 
      ['pattern|' . Regex::EMAIL_PATTERN_REGEX],
    );
    return $this;
  }

  public function validator()
  {
    return $this->validator;
  }

  
}
