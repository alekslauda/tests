<?php

namespace app\Services\Validation;

class Validator {


  private $errors = [];

  public function pattern($type)
  {
    $regexPatterns = Regex::$patterns;
    if (!array_key_exists($type, $regexPatterns)) {
      throw new \Exception('Regex not exists.');
    }

    if (!preg_match($regexPatterns[$type], $this->value)) {
      $this->errors[$this->name][] = 'Field ' . $this->name . ' is an invalid email.';
    }
    return $this;
  }

  public function required()
  {
    if (!trim($this->value)) {
      $this->errors[$this->name][] = 'Field ' . $this->name . ' is required.';
    }
    return $this;
  }

  public function value($value)
  {
    $this->value = $value;
    return $this;
  }

  public function name($name)
  {
    $this->name = $name;
    return $this;
  }

  public function errors()
  {
    return $this->errors;
  }

  public function passed()
  {
    return ! (bool) $this->errors;
  }

}
