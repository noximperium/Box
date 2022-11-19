<?php

namespace NoxImperium\Box\Types\EitherType;

use NoxImperium\Box\Utils\TypeChecker;

abstract class EitherType
{
  protected $value;

  public abstract function contains($element);
  public abstract function exists($predicate);
  public abstract function flatMap($function);
  public abstract function flatten();
  public abstract function filterOrElse($predicate, $value);
  public abstract function forall($predicate);
  public abstract function foreach($function);
  public abstract function isRight();
  public abstract function isLeft();
  public abstract function orElse($either);
  public abstract function map($function);

  public function fold($onLeft, $onRight)
  {
    if ($this->isLeft) return $onLeft($this->value);

    return $onRight($this->value);
  }

  public function get()
  {
    return $this->value;
  }

  public function getOrElse($or)
  {
    $isRight = TypeChecker::isRight($this);
    if ($isRight) return $this->value;

    return $or;
  }

  public function swap()
  {
    $isRight = TypeChecker::isRight($this);
    if ($isRight) return new Left($this->value);

    return new Right($this->value);
  }
}
