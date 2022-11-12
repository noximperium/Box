<?php

namespace NoxImperium\Box\Types;

class Pair
{
  private $first;
  private $second;

  public function __construct($first, $second)
  {
    $this->first = $first;
    $this->second = $second;
  }

  public function setFirst($value)
  {
    $this->first = $value;
  }

  public function first()
  {
    return $this->first;
  }

  public function setSecond($value)
  {
    $this->second = $value;
  }

  public function second()
  {
    return $this->second;
  }
}
