<?php

namespace NoxImperium\Box\Types;

use Exception;
use NoxImperium\Box\Helper;

class Left extends Either
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

  public function orElse($or)
  {
    $isEither = Helper::isEither($or);
    if ($isEither) return $or;

    throw new Exception("Passed value is not Either.");
  }

  public function map($fn)
  {
    return $this;
  }
}
