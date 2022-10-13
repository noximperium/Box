<?php

namespace NoxImperium\Container\Interfaces;

interface Collection
{
  /**
   * Retrieve value of this collection.
   */
  public function val();

  /**
   * Factory function to create Container instance.
   */
  public static function of($value);

  /**
   * Returns true if all elements match the given predicate.
   * @param callable $predicate Accept one argument and return boolean.
   */
  public function all($predicate);

  /**
   * Returns true if at least one element matches the given predicate.
   * @param callable $predicate Accept one argument and return boolean.
   */
  public function any();

  /**
   * Returns true if element is found in the collection
   * @param mixed $element Element to find.
   */
  public function contains($element);

  /**
   * Checks if all elements in the specified collection are contained in this collection.
   * @param Collection Collection to checks.
   */
  public function containsAll($collection);

  /**
   * Returns true if the collection is empty (contains no elements), false otherwise.
   */
  public function isEmpty();

  /**
   * Returns the number of elements in this collection. 
   * If `$predicate` is present, returns the number of elements matching the given predicate.
   * @param callable $predicate Accept one argument and return boolean.
   */
  public function count($predicate = null);

  /**
   * Returns a list containing only distinct elements from the given collection.
   */
  public function distinct();

  /**
   * Returns a list containing only elements from the given collection having distinct keys returned by the given selector function.
   * @param callable $selector Accept one argument and return key.
   */
  public function distinctBy($selector);

  /**
   * Returns a list containing all elements except first n elements.
   * @param int $n Total element to drop.
   */
  public function drop($n);
}
