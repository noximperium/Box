<?php

namespace NoxImperium\Box\Types\OptionType;

abstract class OptionType
{
  private $value;

  public abstract function collect($pairs);
  public abstract function contains($element);
  public abstract function exists($predicate);
  public abstract function filter($predicate);
  public abstract function filterNot($predicate);
  public abstract function flatMap($function);
  public abstract function flatten();
  public abstract function fold($function);
  public abstract function forall($predicate);
  public abstract function foreach($function);
  public abstract function getOrElse($default);
  public abstract function isDefined();
  public abstract function isEmpty();
  public abstract function map($function);
  public abstract function orElse();
  public abstract function orNull();
  public abstract function toLeft($right);
  public abstract function toRight($left);

  public function get()
  {
    return $this->value;
  }
}
