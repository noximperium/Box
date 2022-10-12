<?php

abstract class BaseListContainer
{
  protected $val;

  public function __construct($init)
  {
    $this->val = $init;
  }

  public function at($index)
  {
    $exists = array_key_exists($index, $this->val);
    if (!$exists) throw new Exception('Index not found!');

    return $this->val[$index];
  }

  public function atOr($index = 0, $defautValue = null)
  {
    return $this->val[$index] ?? $defautValue;
  }

  public function contains($element)
  {
    foreach ($this->val as $value) {
      if ($element === $value) return true;
    }

    return false;
  }

  public function count($predicate)
  {
    $count = 0;
    foreach ($this->val() as $value) {
      if ($predicate($value)) $count++;
    }

    return $count;
  }

  public function head()
  {
    return $this->val[0];
  }

  public function tap($fn)
  {
    $fn($this->val);

    return $this;
  }

  public function tail()
  {
    return $this->val[count($this->val) - 1];
  }

  public function size()
  {
    return count($this->val);
  }

  public function val()
  {
    return $this->val;
  }
}
