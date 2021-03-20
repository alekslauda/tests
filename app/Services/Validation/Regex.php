<?php

namespace app\Services\Validation;

class Regex {
  const EMAIL_PATTERN_REGEX = 'email';
  const PHONE_NUMBER_REGEX = 'phone';
  const NAME_REGEX = 'name';

  public static $patterns = [
    self::EMAIL_PATTERN_REGEX => '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',
    self::PHONE_NUMBER_REGEX => '/^[0-9\-\(\)\/\+\s]*$/',
    self::NAME_REGEX => '/^[a-zA-Z\s]+$/',
  ];
}
