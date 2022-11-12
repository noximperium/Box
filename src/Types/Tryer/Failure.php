<?php

namespace NoxImperium\Box\Types\Tryer;

use Exception;
use NoxImperium\Box\Helper;
use NoxImperium\Box\Types\Tryer\Tryer;

class Failure extends Tryer
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
    $isTryer = Helper::isTryer($tryer);
    if ($isTryer) return $tryer;

    throw new Exception("Passed value is not Success nor Failure.");
  }

  public function recover($pairs)
  {
    foreach ($pairs as $pair) {
      $isTrue = $pair->first($this->value);
      if ($isTrue) return new Success($pair->second());
    }

    return $this;
  }

  public function recoverWith($pairs)
  {
    foreach ($pairs as $pair) {
      $isFalse = !$pair->first($this->value);
      if ($isFalse) continue;

      $isTryer = Helper::isTryer($pair->second());
      if ($isTryer) return $pair->second();
    }

    return $this;
  }
}
