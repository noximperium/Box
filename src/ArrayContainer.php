<?php

namespace Src;

class ArrayContainer extends BaseArrayContainer
{
  public function __construct($init)
  {
    parent::__construct($init);
  }

  public function at($index)
  {
    return $this->value[$index];
  }

  public function atOr($index = 0, $defautValue = null)
  {
    return $this->value[$index] ?? $defautValue;
  }

  public function contains($element)
  {
    foreach ($this->value as $value) {
      if ($element === $value) return true;
    }

    return false;
  }

  public function containsAll($elements)
  {
    foreach ($this->value as $value) {
    }

    return false;
  }

  public function drop($n)
  {
    $this->value = array_slice($this->value, $n);

    return $this;
  }

  public function clone()
  {
    return new ArrayContainer($this->value);
  }

  public function get()
  {
    return $this->value;
  }

  public function tail()
  {
    return $this->value[$this->length - 1];
  }

  public function head()
  {
    return $this->value[0];
  }


  public function map($mapFn)
  {
    $this->value = array_map($mapFn, $this->value);

    return $this;
  }

  public function tap($fn)
  {
    $fn($this->value);

    return $this;
  }

  public function take($n)
  {
    $this->value = array_slice($this->value, 0, $n);

    return $this;
  }

  public function filter($filterFn)
  {
    $result = [];

    foreach ($this->value as $key => $value) {
      $eligible = $filterFn($value, $key);
      if ($eligible) $result[] = $value;
    }

    $this->value = $result;

    return $this;
  }

  public function size()
  {
    return count($this->value);
  }
}

class MutableArrayContainer
{
  private $array;

  public function __construct($init)
  {
    $this->array = $init;
  }

  function map($mapFn)
  {
    $this->array = array_map($mapFn, $this->array);
    return $this;
  }
}

class ImmutableArrayContainer
{
  private $array;

  public function __construct($init)
  {
    $this->array = $init;
  }

  function map($mapFn)
  {
    $newValue = array_map($mapFn, $this->array);
    return new ImmutableArrayContainer($newValue);
  }
}
