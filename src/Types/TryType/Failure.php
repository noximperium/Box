<?php

namespace NoxImperium\Box\Types\TryType;

use Exception;
use NoxImperium\Box\Types\TryType\TryType;
use NoxImperium\Box\Utils\TypeChecker;

class Failure extends TryType
{
  public function __construct($value)
  {
    $this->value = $value;
  }

  public function collect($pairs)
  {
    foreach ($pairs as $pair) {
      $isTrue = $pair->first($this->value);
      if ($isTrue) return new Success($pair->second());
    }
  }

  public function filter($predicate)
  {
    return $this;
  }

  public function flatMap($function)
  {
    return $this;
  }

  public function flatten()
  {
    return $this;
  }

  public function foreach($function)
  {
    return;
  }

  public function get()
  {
    throw new Exception($this->value);
  }

  public function getOrElse($default)
  {
    return $default;
  }

  public function isFailure()
  {
    return true;
  }

  public function isSuccess()
  {
    return false;
  }

  public function map($fn)
  {
    return $this;
  }

  public function orElse($tryer)
  {
    $isTryer = TypeChecker::isTryer($tryer);
    if ($isTryer) return $tryer;

    throw new Exception("Passed value is not Success nor Failure.");
  }

  public function recover($function)
  {
    $result = $function($this->value);

    return new Success($result);
  }

  public function recoverWith($function)
  {
    $result = $function($this->value);
    $isTryer = TypeChecker::isTryer($result);

    if ($isTryer) return $result;

    return $this;
  }
}
