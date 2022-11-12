<?php

namespace NoxImperium\Box\Types;

use Exception;
use NoxImperium\Box\Helper;

class Right extends Either
{
  public function __construct($value)
  {
    $this->value = $value;
  }

  public function contains($element)
  {
    return $this->value === $element;
  }

  public function exists($predicate)
  {
    return $predicate($this->value);
  }

  public function flatten()
  {
    $isEither = Helper::isEither($this->value);
    if ($isEither) return $this->value;

    throw new Exception("The content inside this Either is not Either.");
  }

  public function flatMap($fn)
  {
    $result = $fn($this->value);
    if (Helper::isEither($result)) return $result;

    throw new Exception("The result of transformation is not Either.");
  }

  public function filterOrElse($predicate, $zero)
  {
    $isTrue = $predicate($this->value) === true;
    if ($isTrue) return $this;

    return new Left($zero);
  }

  public function forall($predicate)
  {
    $isTrue = $predicate($this->value) === true;
    if ($isTrue) return true;

    return false;
  }

  public function foreach($predicate)
  {
    $predicate($this->value);
  }

  public function isLeft()
  {
    return false;
  }

  public function isRight()
  {
    return true;
  }

  public function orElse($or)
  {
    return $this;
  }

  public function map($fn)
  {
    $result = $fn($this->value);

    return new Right($result);
  }
}
