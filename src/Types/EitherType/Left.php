<?php

namespace NoxImperium\Box\Types\EitherType;

use Exception;
use NoxImperium\Box\Utils\TypeChecker;

class Left extends EitherType
{
  public function __construct($value)
  {
    $this->value = $value;
  }

  public function contains($element)
  {
    return false;
  }

  public function exists($predicate)
  {
    return false;
  }

  public function flatten()
  {
    return $this;
  }

  public function flatMap($fn)
  {
    return $this;
  }

  public function filterOrElse($predicate, $value)
  {
    return $this;
  }

  public function forall($predicate)
  {
    return true;
  }

  public function foreach($predicate)
  {
    return;
  }

  public function isLeft()
  {
    return true;
  }

  public function isRight()
  {
    return false;
  }

  public function map($fn)
  {
    return $this;
  }

  public function orElse($or)
  {
    $isEither = TypeChecker::isEither($or);
    if ($isEither) return $or;

    throw new Exception("Passed value is not Either.");
  }
}
