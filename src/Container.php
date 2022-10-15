<?php

/**
 * Consumer: Represents an operation that accepts a single input argument and returns no result.
 * Function: Represents a function that accepts one argument and produces a result.
 * Predicate: Represents a predicate (boolean-valued function) of one argument.
 * Supplier: Represents a supplier of results.
 */

/**
 * Type of methods
 * 1. Core
 * 2. Modifier
 * 3. Aggregate
 */

abstract class Container
{
  protected $val;

  /**
   * Returns an instance of `Container` with passed initial value.
   * @param array $init An initial value.
   * @return Container A new instance of `Container`
   */
  public abstract static function of($value);

  public function val()
  {
    return $this->val;
  }

  public function all($biPredicate)
  {
    foreach ($this->val as $key => $value) {
      if (!$biPredicate($value, $key)) return false;
    }

    return true;
  }

  public function any($predicate)
  {
    foreach ($this->val as $key => $value) {
      if ($predicate($value, $key)) return true;
    }

    return false;
  }

  public function chunk($size)
  {
  }

  public function concat($elements)
  {
  }

  public function contains($element)
  {
  }

  /**
   * Returns the number of elements matching the given predicate.
   * @param $biPredicate (value, key) => boolean
   */
  public function count($biPredicate)
  {
    $count = 0;
    foreach ($this->val as $key => $value) {
      if ($biPredicate($value, $key)) $count++;
    }

    return $count;
  }
}
