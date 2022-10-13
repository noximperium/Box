<?php

namespace NoxImperium\Container;

use Exception;
use PhpParser\Node\Expr\Exit_;

class ImmutableArray
{
  private array $val;

  private function __construct($init)
  {
    $this->val = $init;
  }

  /**
   * Returns an instance of ImmutableArray with passed initial value.
   * @param array $init An initial value.
   * @return ImmutableArray A new instance of ImmutableArray
   */
  public static function of($init = [])
  {
    if (gettype($init) !== 'array') throw new Exception('Initial value must be an array');

    return new ImmutableArray($init);
  }

  /**
   * Returns a fixed list of size n containing a specified identical value.
   * @param mixed $value The value to repeat.
   * @param int $n The desired size of the output list.
   * @return ImmutableArray A new array containing `$n` `$value`s.
   */
  public static function repeat($value, $n)
  {
    $result = [];

    for ($i = 0; $i < $n; $i++) {
      $result[] = $value;
    }

    return new ImmutableArray($result);
  }

  public function val()
  {
    return $this->val;
  }

  /**
   * Applies a function to the value at the given index of an array, 
   * returning a new copy of the array with the element at the given index replaced with the result of the function application.
   * @param int $index The index.
   * @param callable $fn The function to apply.
   * @return ImmutableArray A copy of the supplied array-like object with the element at index `$idx` replaced with the value returned by applying `$fn` to the existing element.
   */
  public function adjust($index, $fn)
  {
    $exists = array_key_exists($index, $this->val);
    if (!$exists) throw new Exception('Index not found.');

    $this->val[$index] = $fn($this->val[$index]);

    return new ImmutableArray($this->val);
  }

  /**
   * Returns true if all elements of the list match the predicate, false if there are any that don't.
   * @param callable $predicate The predicate function.
   * @return boolean `true` if the predicate is satisfied by every element, `false` otherwise.
   */
  public function all($predicate)
  {
    foreach ($this->val as $item) {
      if (!$predicate($item)) return false;
    }

    return true;
  }

  /**
   * Returns true if at least one of the elements of the list match the predicate, false otherwise.
   * @param callable $predicate The predicate function.
   * @return boolean `true` if the predicate is satisfied by at least one element, `false` otherwise.
   */
  public function any($predicate)
  {
    foreach ($this->val as $item) {
      if ($predicate($item)) return true;
    }

    return false;
  }

  /**
   * Returns a new list, composed of n-tuples of consecutive elements. 
   * If n is greater than the length of the list, an empty list is returned.
   * @param int $n The size of the tuples to create
   * @return ImmutableArray The resulting list of `n`-length tuples
   */
  public function aperture($n)
  {
    if ($n > count($this->val)) return [];

    $nIteration = count($this->val) - $n + 1;
    $temp = $this->val;
    $result = [];

    for ($i = 0; $i < $nIteration; $i++) {
      $result[] = array_slice($temp, 0, $n);
      $temp = array_slice($temp, 1);
    }

    return new ImmutableArray($result);
  }

  /**
   * Returns a new list containing the contents of the given list, followed by the given element.
   * @param mixed $element The element to add to the end of the new list.
   * @return ImmutableArray A new list containing the elements of the old list followed by `$element`.
   */
  public function append($element)
  {
    if (gettype($element) === 'array') throw new Exception('Element must not be an array!');

    $this->val[] = $element;
    return new ImmutableArray($this->val);
  }

  /**
   * Returns average value of this `ImmutableArray` (on specified path if supplied).
   */
  public function average($path = null)
  {
    if ($path === null && !$this->isContentScalar()) throw new Exception('Contents is not scalar.');

    if ($path) $values = $this->pluck($path)->val;
    else $values = $this->val;

    return array_sum($values) / count($values);
  }

  /**
   * Breaks this `ImmutableArray` into multiple, smaller array of a given size:
   */
  public function chunk($size)
  {
    $chunked = [];
    $temp = [];

    foreach ($this->val as $value) {
      $temp[] = $value;
      if (count($temp) === $size) {
        $chunked[] = $temp;
        $temp = [];
      }
    }

    if (count($temp) !== 0) $chunked[] = $temp;

    return new ImmutableArray($chunked);
  }

  /**
   * Returns the result of concatenating the given lists or strings.
   * @param array $array The list
   * @return ImmutableArray A list consisting of the elements of current value followed by the elements of `$array`.
   */
  public function concat($array)
  {
    return new ImmutableArray(array_merge($this->val, $array));
  }

  /**
   * Checks if the specified element is contained in this collection.
   */
  public function contains($element)
  {
    foreach ($this->val as $value) {
      if ($element === $value) return true;
    }

    return false;
  }

  /**
   * Returns the number of elements matching the given predicate.
   */
  public function count($predicate)
  {
    $count = 0;
    foreach ($this->val() as $value) {
      if ($predicate($value)) $count++;
    }

    return $count;
  }

  /**
   * Returns a list containing only distinct elements from the given collection.
   * @return ImmutableArray A new instance with distinct elements.
   */
  public function distinct()
  {
    $result = [];
    foreach ($this->val as $value) {
      if (!in_array($value, $result)) $result[] = $value;
    }

    return new ImmutableArray($result);
  }

  /**
   * Returns all but the first n elements of the given list.
   * @param int $n Total element to drop.
   * @return ImmutableArray A copy of list without the first `$n` elements
   */
  public function drop($n)
  {
    $val = array_slice($this->val, $n);

    return new ImmutableArray($val);
  }

  /**
   * Returns a list containing all but the last n elements of the given list.
   * @param int $n Total element to drop.
   * @return ImmutableArray A copy of list without the last `$n` elements
   */
  public function dropLast($n)
  {
    $val = array_slice($this->val, 0, count($this->val()) - $n);

    return new ImmutableArray($val);
  }

  /**
   * Returns a new list excluding all the tailing elements of a given list which satisfy the supplied predicate function. 
   * It passes each value from the right to the supplied predicate function, skipping elements until the predicate 
   * function returns a falsy value. The predicate function is applied to one argument: (value).
   * @param callable $predicate The function to be called on each element
   * @return ImmutableValue A new array without any trailing elements that return `falsy` values from the `$predicate`.
   */
  public function dropLastWhile($predicate)
  {
    $endIndex = -1;

    for ($i = count($this->val) - 1; $i >= 0; $i--) {
      $element = $this->val[$i];
      if ($predicate($element)) $endIndex = $i;
      else break;
    }

    return new ImmutableArray(array_slice($this->val, 0, $endIndex));
  }

  /**
   * Returns a new list excluding the leading elements of a given list which satisfy the supplied predicate function.
   * It passes each value to the supplied predicate function, 
   * skipping elements while the predicate function returns true. 
   * The predicate function is applied to one argument: (value).
   * @param callable $predicate The function called per iteration.
   * @return ImmutableValue A new array without any leading elements that return `falsy` values from the `$predicate`.
   */
  public function dropWhile($predicate)
  {
    $result = [];

    foreach ($this->val as $value) {
      if (!$predicate($value)) $result[] = $value;
    }

    return new ImmutableArray($result);
  }

  /**
   * Returns a new list without any consecutively repeating elements. `===` operator is used to determine equality.
   * @return ImmutableArray A new array without repeating elements.
   */
  public function dropRepeats()
  {
    $result = [$this->val[0]];

    for ($i = 1; $i < count($this->val); $i++) {
      $currentValue = $this->val[$i];
      $previousValue = $result[count($result) - 1];
      if ($currentValue !== $previousValue) $result[] = $this->val[$i];
    }

    return new ImmutableArray($result);
  }

  /**
   * Returns a new list without any consecutively repeating elements. 
   * Equality is determined by applying the supplied predicate to each pair of consecutive elements. 
   * The first element in a series of equal elements will be preserved.
   * @param callable $biPredicate A predicate used to test whether two items are equal.
   * @return ImmutableArray A new array without repeating elements.
   */
  public function dropRepeatsWith($biPredicate)
  {
    $result = [$this->val[0]];

    for ($i = 1; $i < count($this->val); $i++) {
      $currentValue = $this->val[$i];
      $previousValue = $result[count($result) - 1];

      if ($biPredicate($currentValue, $previousValue)) $result[] = $this->val[$i];
    }

    return new ImmutableArray($result);
  }

  /**
   * Checks if a list ends with the provided sublist or value.
   * @param array|mixed $suffix Checks if a list ends with the provided sublist.
   * @return boolean Whether current list ended with `$suffix` or not.
   */
  public function endsWith($suffix)
  {
    $lastIndex = count($this->val) - 1;

    if (gettype($suffix) !== 'array') {
      return $this->val[$lastIndex] === $suffix;
    }

    $length = count($suffix);
    $valueToCheck = array_slice($this->val, count($this->val) - $length);

    if ($valueToCheck === $suffix) return true;

    return false;
  }

  /**
   * Returns a list containing only elements matching the given predicate.
   * @param callable $predicate A predicate used to test whether the element should be included.
   * @return ImmutableArray A new array with only element that satisfy `$predicate`.
   */
  public function filter($predicate)
  {
    $result = [];

    foreach ($this->val as $value) {
      $eligible = $predicate($value);
      if ($eligible) $result[] = $value;
    }

    return new ImmutableArray($result);
  }

  /**
   * Returns a list containing only elements matching the given bipredicate.
   * @param callable $biPredicate A predicate used to test whether the element should be included.
   * @return ImmutableArray A new array with only element that satisfy `$biPredicate`.
   */
  public function filterIndexed($biPredicate)
  {
    $result = [];

    foreach ($this->val as $index => $value) {
      $eligible = $biPredicate($index, $value);
      if ($eligible) $result[] = $value;
    }

    return new ImmutableArray($result);
  }

  /**
   * Returns a list containing all elements not matching the given predicate.
   * @param callable $predicate A predicate used to test whether the element should be included.
   * @return ImmutableArray A new array with only element that dissatisfy `$predicate`.
   */
  public function filterNot($predicate)
  {
    $result = [];

    foreach ($this->val as $value) {
      $eligible = !$predicate($value);
      if ($eligible) $result[] = $value;
    }

    return new ImmutableArray($result);
  }

  /**
   * Returns a list containing all elements that are not null.
   * @return ImmutableArray A new array without null value.
   */
  public function filterNotNull()
  {
    $result = [];

    foreach ($this->val as $value) {
      if ($value !== null) $result[] = $value;
    }

    return new ImmutableArray($result);
  }

  /**
   * Returns the first element matching the given predicate, or `null` if no such element was found.
   * @param callable $predicate The predicate function used to determine if the element is the desired one.
   * @return mixed|null The element found, or `null`.
   */
  public function find($predicate)
  {
    foreach ($this->val as $value) {
      if ($predicate($value)) return $value;
    }

    return null;
  }

  /**
   * Returns the last element matching the given predicate, or `null` if no such element was found.
   * @param callable $predicate The predicate function used to determine if the element is the desired one.
   * @return mixed|null The element found, or `null`.
   */
  public function findLast($predicate)
  {
    for ($i = count($this->val) - 1; $i >= 0; $i++) {
      $element = $this->val[$i];
      if ($predicate($element)) return $element;
    }

    return null;
  }

  /**
   * Returns the first element.
   * @return mixed Element on first index.
   */
  public function first()
  {
    $length = count($this->val);
    if ($length === 0) throw new Exception('The array is empty.');

    return $this->val[0];
  }

  /**
   * Returns the first non-null value produced by transform function being applied to elements of this collection in iteration order, 
   * or throws Exception if no non-null value was produced.
   * @param callable $transform 
   * @return mixed
   */
  public function firstNotNullOf($transform)
  {
    foreach ($this->val as $value) {
      $result = $transform($value);
      if ($result !== null) return $value;
    }

    throw new Exception('No such element found.');
  }

  /**
   * Returns the first non-null value produced by transform function being applied to elements of this collection in iteration order, 
   * or null if no non-null value was produced.
   * @param callable $transform
   * @return mixed
   */
  public function firstNotNullOfOrNull($transform)
  {
    foreach ($this->val as $value) {
      $result = $transform($value);
      if ($result !== null) return $value;
    }

    return null;
  }

  /**
   * Returns the first element, or null if the list is empty.
   * @return mixed
   */
  public function firstOrNull()
  {
    $length = count($this->val);
    if ($length === 0) return null;

    return $this->val[0];
  }

  /**
   * Returns a single list of all elements yielded from results of transform function being invoked on each element of original collection.
   * @param callable $transform
   * @return ImmutableArray
   */
  public function flatMap($transform)
  {
    $result = [];
    foreach ($this->val as $value) {
      $result = array_merge($result, $transform($value));
    }

    return new ImmutableArray($result);
  }

  /**
   * Returns a single list of all elements yielded from results of transform function being invoked on each element and its index in the original collection.
   */
  public function flatMapIndexed($transform)
  {
    $result = [];
    foreach ($this->val as $index => $value) {
      $result = array_merge($result, $transform($index, $value));
    }

    return new ImmutableArray($result);
  }

  private function recurseFlatten($value)
  {
    $result = [];
    foreach ($value as $item) {
      if (gettype($item) !== 'array') $result[] = $item;
      else $result = array_merge($result, $this->recurseFlatten($item));
    }

    return $result;
  }

  /**
   * Returns a new list by pulling every item out of it (and all its sub-arrays) and putting them in a new array.
   */
  public function flatten()
  {
    $result = $this->recurseFlatten($this->val);

    return new ImmutableArray($result);
  }

  /**
   * Accumulates value starting with initial value and applying operation from left to right to current accumulator value and each element.
   * @param mixed $initial
   * @param callable $operation
   * @return mixed
   */
  public function fold($initial, $operation)
  {
    $accumulator = $initial;

    foreach ($this->val as $value) {
      $accumulator = $operation($accumulator, $value);
    }

    return $accumulator;
  }

  /**
   * Accumulates value starting with initial value and applying operation from left to right to current accumulator value 
   * and each element with its index in the original collection.
   * @param mixed $initial
   * @param callable $operation
   * @return mixed
   */

  public function foldIndexed($initial, $operation)
  {
    $accumulator = $initial;

    foreach ($this->val as $index => $value) {
      $accumulator = $operation($index, $accumulator, $value);
    }

    return $accumulator;
  }

  /**
   * Accumulates value starting with initial value and applying operation from right to left to each element and current accumulator value.
   * @param mixed $initial
   * @param callable $operation
   * @return mixed
   */
  public function foldRight($initial, $operation)
  {
    $accumulator = $initial;
    $lastIndex = count($this->val) - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $this->val[$i]);
    }

    return $accumulator;
  }

  /**
   * Accumulates value starting with initial value and applying operation from right to left to each element 
   * with its index in the original list and current accumulator value.
   * @param mixed $initial
   * @param callable $operation
   * @return mixed
   */
  public function foldRightIndexed($initial, $operation)
  {
    $accumulator = $initial;
    $lastIndex = count($this->val) - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($i, $accumulator, $this->val[$i]);
    }

    return $accumulator;
  }

  /**
   * Performs the given action on each element.
   * @param callable $action
   */
  public function forEach($action)
  {
    foreach ($this->val as $value) $action($value);
  }

  /**
   * Performs the given action on each element, providing sequential index with the element.
   * @param callable $action
   */
  public function forEachIndexed($action)
  {
    foreach ($this->val as $index => $value) $action($index, $value);
  }

  /**
   * Returns the element at the specified index in the list.
   * @param int $index Index of array to retrieve.
   */
  public function get($index)
  {
    return $this->val[$index];
  }

  /**
   * Returns an element at the given index or the result of calling the defaultValue function if the index is out of bounds of this list.
   * @param int $index
   * @param mixed $defaultValue
   * @return mixed
   */
  public function getOrElse($index, $defaultValue)
  {
    return $this->val[$index] ?? $defaultValue;
  }

  /**
   * Returns an element at the given index or null if the index is out of bounds of this list.
   * @param int $index
   * @return mixed
   */
  public function getOrNull($index)
  {
    return $this->val[$index] ?? null;
  }

  /**
   * Groups values returned by the valueTransform function (if passed) applied to each element of the original collection 
   * by the key returned by the given keySelector function applied to the element and 
   * returns a map where each group key is associated with a list of corresponding values.
   * @param callable $keySelector
   * @param callable $valueTransform
   * @return ImmutableMap 
   */
  public function groupBy($keySelector, $valueTransform = null)
  {
    $result = [];

    foreach ($this->val as $value) {
      if ($valueTransform) $value = $valueTransform($value);
      $key = $keySelector($value);
      $keyExists = array_key_exists($key, $result);

      if ($keyExists) $result[$key][] = $value;
      else $result += [$key => [$value]];
    }

    return ImmutableMap::of($result);
  }

  /**
   * Returns the first element of this ImmutableArray.
   */
  public function head()
  {
    return $this->val[0];
  }


  /**
   * Fill this ImmutableArray with specified value if currently empty.
   * @param $default
   * @return ImmutableArray
   */
  public function ifEmpty($default)
  {
    if (gettype($default) !== 'array') throw new Exception('Default value should be an array.');

    if (count($this->val) === 0) return new ImmutableArray($default);

    return $this;
  }

  /**
   * Returns first index of element, or -1 if the list does not contain element.
   * @param mixed $element 
   * @return int
   */
  public function indexOf($element)
  {
    foreach ($this->val as $index => $value) {
      if ($value === $element) return $index;
    }

    return -1;
  }

  /**
   * Returns index of the first element matching the given predicate, or -1 if the list does not contain such element.
   * @param callable $predicate
   * @return int;
   */
  public function indexOfFirst($predicate)
  {
    foreach ($this->val as $index => $value) {
      if ($predicate($value)) return $index;
    }

    return -1;
  }

  /**
   * Returns index of the last element matching the given predicate, or -1 if the list does not contain such element.
   * @param callable $predicate
   * @return int;
   */
  public function indexOfLast($predicate)
  {
    $lastIndex = count($this->val) - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      if ($predicate($this->val[$i])) return $i;
    }

    return -1;
  }

  /**
   * Returns true if the collection is not empty.
   */
  public function isNotEmpty()
  {
    if (count($this->val) === 0) return false;

    return true;
  }

  /**
   * Creates a string from all the elements separated using separator and using the given prefix and postfix if supplied.
   */
  public function joinToString($separator = ', ', $prefix = '', $postfix = '', $limit = -1, $truncated = '...')
  {
    $result = $prefix;
    $limitIndex = $limit - 1;
    $lastIndex = count($this->val) - 1;

    foreach ($this->val as $index => $value) {
      if ($index === $limitIndex) {
        $result .= $truncated;
        break;
      }

      $result .= $value;
      if ($index !== $lastIndex) $result .= $separator;
    }

    $result .= $postfix;

    return $result;
  }

  /**
   * Returns the last element.
   */
  public function last()
  {
    $length = count($this->val);
    if ($length === 0) throw new Exception('Array is empty.');

    return $this->val[$length - 1];
  }

  /**
   * Returns last index of element, or -1 if the list does not contain element.
   */
  public function lastIndexOf($element)
  {
    $lastIndex = count($this->val) - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      if ($element === $this->val[$i]) return $i;
    }

    return -1;
  }

  /**
   * Returns the last element, or null if the list is empty.
   */
  public function lastOrNull()
  {
    $length = count($this->val);
    if ($length === 0) null;

    return $this->val[$length - 1];
  }

  /**
   * Returns a list containing the results of applying the given transform function to each element in the original collection.
   */
  public function map($transform)
  {
    $result = [];

    foreach ($this->val as $value) {
      $result[] = $transform($value);
    }

    return new ImmutableArray($result);
  }

  /**
   * Returns a list containing the results of applying the given transform function to each element and its index in the original collection.
   */
  public function mapIndexed($transform)
  {
    $result = [];

    foreach ($this->val as $index => $value) {
      $result[] = $transform($index, $value);
    }

    return new ImmutableArray($result);
  }

  /**
   * Returns a list containing only the non-null results of applying the given transform function to each element and its index in the original collection.
   */
  public function mapIndexedNotNull($transform)
  {
    $result = [];

    foreach ($this->val as $index => $value) {
      $resultValue  = $transform($index, $value);
      if ($resultValue !== null) $result[] = $resultValue;
    }

    return new ImmutableArray($result);
  }

  /**
   * Returns a list containing only the non-null results of applying the given transform function to each element in the original collection.
   */
  public function mapNotNull($transform)
  {
    $result = [];

    foreach ($this->val as $value) {
      $resultValue = $transform($value);
      if ($resultValue !== null) $result[] = $resultValue;
    }

    return new ImmutableArray($result);
  }

  /**
   * Returns true if the collection has no elements.
   */
  public function none($predicate = null)
  {
    $zeroLength = count($this->val) === 0;

    if ($predicate === null && $zeroLength) return true;
    else if ($predicate === null && !$zeroLength) return false;

    foreach ($this->val as $item) {
      if ($predicate($item)) return false;
    }

    return true;
  }

  /**
   * Performs the given action on each element and returns the collection itself afterwards.
   */
  public function onEach($action)
  {
    foreach ($this->val as $value) {
      $action($value);
    }

    return $this;
  }

  /**
   * Performs the given action on each element, providing sequential index with the element, and returns the collection itself afterwards.
   */
  public function onEachIndexed($action)
  {
    foreach ($this->val as $index => $value) {
      $action($index, $value);
    }

    return $this;
  }

  /**
   * Takes a predicate and returns the pair of array of elements which do and do not satisfy, the predicate, respectively. 
   * @param callable $predicate A predicate to determine which side the element belongs to.
   * @return array An array, containing first the subset of elements that satisfy the predicate, and second the subset of elements that do not satisfy.
   */
  public function partition($predicate)
  {
    $satisfy = [];
    $dissatisfy = [];

    foreach ($this->val as $value) {
      if ($predicate($value)) $satisfy[] = $value;
      else $dissatisfy[] = $value;
    }

    return new ImmutableArray([$satisfy, $dissatisfy]);
  }

  /** 
   * Returns a new list by plucking the same named property off all objects in the list supplied.
   * @param String $key The key name to pluck off of each object.
   */
  public function pluck($key)
  {
    $keys = explode('.', $key);

    $result = array_map(function ($value) use ($keys) {
      $ref = $value;

      foreach ($keys as $key) {
        if (array_key_exists($key, $ref)) $ref = $ref[$key];
        else return null;
      }

      return $ref;
    }, $this->val);

    return new ImmutableArray($result);
  }

  /**
   * Returns a new list with the given element at the front, followed by the contents of the list.
   */
  public function prepend($element)
  {
    $result = [$element, ...$this->val];

    return new ImmutableArray($result);
  }

  /**
   * Accumulates value starting with the first element and applying operation from left to right to current accumulator value and each element.
   */
  public function reduce($operation)
  {
    $length = count($this->val);
    if ($length === 0) throw new Exception('Array is empty.');

    $accumulator = $this->val[0];

    for ($i = 1; $i < $length; $i++) {
      $accumulator = $operation($accumulator, $this->val[$i]);
    }

    return $accumulator;
  }

  /**
   * Accumulates value starting with the first element and applying operation from left to right to current accumulator value 
   * and each element with its index in the original collection.
   */
  public function reduceIndexed($operation)
  {
    $length = count($this->val);
    if ($length === 0) throw new Exception('Array is empty.');

    $accumulator = $this->val[0];

    for ($i = 1; $i < $length; $i++) {
      $accumulator = $operation($i, $accumulator, $this->val[$i]);
    }

    return $accumulator;
  }

  /**
   * Accumulates value starting with the first element and applying operation from left to right to current accumulator value and each element.
   */
  public function reduceOrNull($operation)
  {
    $length = count($this->val);
    if ($length === 0) return null;

    $accumulator = $this->val[0];

    for ($i = 1; $i < $length; $i++) {
      $accumulator = $operation($accumulator, $this->val[$i]);
    }

    return $accumulator;
  }

  /**
   * Accumulates value starting with the first element and applying operation from left to right to current accumulator value 
   * and each element with its index in the original collection.
   */
  public function reduceIndexedOrNull($operation)
  {
    $length = count($this->val);
    if ($length === 0) return null;

    $accumulator = $this->val[0];

    for ($i = 1; $i < $length; $i++) {
      $accumulator = $operation($i, $accumulator, $this->val[$i]);
    }

    return $accumulator;
  }

  /**
   * Accumulates value starting with the last element and applying operation from right to left to each element and current accumulator value.
   */
  public function reduceRight($operation)
  {
    $length = count($this->val);
    if ($length === 0) throw new Exception('Array is empty.');

    $accumulator = $this->val[0];
    $lastIndex = $length - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $this->val[$i]);
    }

    return $accumulator;
  }

  /**
   * Accumulates value starting with the last element and applying operation from right to left to each element 
   * with its index in the original list and current accumulator value.
   */
  public function reduceRightIndexed($operation)
  {
    $length = count($this->val);
    if ($length === 0) throw new Exception('Array is empty.');

    $accumulator = $this->val[0];
    $lastIndex = $length - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($i, $accumulator, $this->val[$i]);
    }

    return $accumulator;
  }

  /**
   * Accumulates value starting with the last element and applying operation from right to left to each element 
   * with its index in the original list and current accumulator value.
   */
  public function reduceRightIndexedOrNull($operation)
  {
    $length = count($this->val);
    if ($length === 0) return null;

    $accumulator = $this->val[0];
    $lastIndex = $length - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($i, $accumulator, $this->val[$i]);
    }

    return $accumulator;
  }

  /**
   * Accumulates value starting with the last element and applying operation from right to left to each element and current accumulator value.
   */
  public function reduceRightOrNull($operation)
  {
    $length = count($this->val);
    if ($length === 0) return null;

    $accumulator = $this->val[0];
    $lastIndex = $length - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $this->val[$i]);
    }

    return $accumulator;
  }

  /**
   * Returns a list with elements in reversed order.
   */
  public function reverse()
  {
    return new ImmutableArray(array_reverse($this->val));
  }

  /**
   * Returns a list containing successive accumulation values generated by applying operation from left to right 
   * to each element and current accumulator value that starts with initial value.
   */
  public function runningFold($initial, $operation)
  {
    $accumulator = $initial;
    $result = [$accumulator];

    foreach ($this->val as $value) {
      $accumulator = $operation($accumulator, $value);
      $result[] = $accumulator;
    }

    return $result;
  }

  /**
   * Returns a list containing successive accumulation values generated by applying operation from left to right 
   * to each element, its index in the original collection and current accumulator value that starts with initial value.
   */
  public function runningFoldIndexed($initial, $operation)
  {
    $accumulator = $initial;
    $result = [$accumulator];

    foreach ($this->val as $index => $value) {
      $accumulator = $operation($index, $accumulator, $value);
      $result[] = $accumulator;
    }

    return $result;
  }

  /**
   * Returns a list containing successive accumulation values generated by applying operation from left to right
   * to each element and current accumulator value that starts with the first element of this collection.
   */
  public function runningReduce($operation)
  {
    $length = count($this->val);
    $accumulator = $this->val[0];
    $result = [$accumulator];

    for ($i = 1; $i < $length; $i++) {
      $accumulator = $operation($accumulator, $this->val[$i]);
      $result[] = $accumulator;
    }

    return $result;
  }

  /**
   * Returns a list containing successive accumulation values generated by applying operation from left to right
   * to each element, its index in the original collection and current accumulator value that starts with the first element of this collection.
   */
  public function runningReduceIndexed($operation)
  {
    $length = count($this->val);
    $accumulator = $this->val[0];
    $result = [$accumulator];

    for ($i = 1; $i < $length; $i++) {
      $accumulator = $operation($i, $accumulator, $this->val[$i]);
      $result[] = $accumulator;
    }

    return $result;
  }

  /**
   * Returns the elements of the given list from fromIndex (inclusive) to toIndex (exclusive).
   * @param int $from (inclusive)
   * @param int $to (exclusive)
   * @param ImmutableArray $list
   */
  public function slice($from, $to)
  {
    return new ImmutableArray(array_slice($this->val, $from, $to - $from));
  }

  /**
   * Returns a list of all elements sorted according to natural sort order of the value returned by specified selector function.
   */
  public function sortBy($selector)
  {
    $result = $this->val;
    usort($result, function ($a, $b) use ($selector) {
      return $selector($a) - $selector($b);
    });

    return new ImmutableArray($result);
  }

  /**
   * Returns a list of all elements sorted descending according to natural sort order of the value returned by specified selector function.
   */
  public function sortByDescending($selector)
  {
    $result = $this->val;
    usort($result, function ($a, $b) use ($selector) {
      return $selector($b) - $selector($a);
    });

    return new ImmutableArray($result);
  }

  /**
   * Returns a list containing first n elements.
   */
  public function take($n)
  {
    $result = array_slice($this->val, 0, $n);

    return new ImmutableArray($result);
  }

  /**
   * Returns a list containing last n elements.
   */
  public function takeLast($n)
  {
    $result = array_slice($this->val, count($this->val) - $n);

    return new ImmutableArray($result);
  }

  /**
   * Returns a list containing last elements satisfying the given predicate.
   */
  public function takeLastWhile($predicate)
  {
    $result = [];
    $length = count($this->val);

    for ($i = $length - 1; $i >= 0; $i--) {
      if ($predicate($this->val[$i])) $result[] = $this->val[$i];
      else break;
    }

    return new ImmutableArray($result);
  }

  /**
   * Returns a list containing first elements satisfying the given predicate.
   */
  public function takeWhile($predicate)
  {
    $result = [];
    $length = count($this->val);

    for ($i = 0; $i < $length; $i++) {
      if ($predicate($this->val[$i])) $result[] = $this->val[$i];
      else break;
    }

    return new ImmutableArray($result);
  }

  /**
   * Inserts the supplied element into the list, at the specified index.
   */
  public function insert($index, $element)
  {
    $a = array_slice($this->val, 0, $index);
    $b = array_slice($this->val, $index);
    $result = [...$a, $element, ...$b];

    return new ImmutableArray($result);
  }

  /**
   * Inserts the sub-list into the list, at the specified index.
   */
  public function insertAll($index, $elements)
  {
    $a = array_slice($this->val, 0, $index);
    $b = array_slice($this->val, $index);
    $result = [...$a, ...$elements, ...$b];

    return new ImmutableArray($result);
  }

  /**
   * Creates a new list with the separator interposed between elements.
   */
  public function intersperse($separator)
  {
    $result = [];
    $lastIndex = count($this->val) - 1;
    foreach ($this->val as $key => $value) {
      $result[] = $value;
      if ($key !== $lastIndex) $result[] = $separator;
    }

    return new ImmutableArray($result);
  }

  /**
   * Move an item, at index `$from`, to index `$to`, in a list of elements. A new list will be created containing the new elements order.
   */
  public function move($from, $to)
  {
    $result = $this->val;
    $a = $result[$from];
    $b = $result[$to];

    $result[$from] = $b;
    $result[$to] = $a;

    return new ImmutableArray($result);
  }

  /**
   * Removes the sub-list of list starting at index start and containing count elements. 
   * @param int $start The position to start removing elements
   * @param int $count The number of elements to remove
   * @return ImmutableArray A new Array with `$count` elements from `$start` removed.
   */
  public function remove($start, $count)
  {
    $result = [];

    foreach ($this->val as $index => $value) {
      $isValid = $index < $start || $index >= $start + $count;
      if ($isValid) $result[] = $value;
    }

    return new ImmutableArray($result);
  }

  /**
   * Checks if a list starts with the provided sublist or value.
   */
  public function startsWith($prefix)
  {
    if (gettype($prefix) !== 'array') {
      return $this->val[0] === $prefix;
    }

    $length = count($prefix);
    $valueToCheck = array_slice($this->val, 0, $length);

    if ($valueToCheck === $prefix) return true;

    return false;
  }

  /**
   * Returns the size of the collection.
   */
  public function size()
  {
    return count($this->val);
  }

  /**
   * Returns all but the first element of the given list or string (or object with a tail method).
   */
  public function tail()
  {
    return array_slice($this->val, 1);
  }

  /**
   * Runs the given function with the supplied object, then returns the object.
   */
  public function tap($fn)
  {
    $fn($this->val);

    return $this;
  }

  private function isContentScalar()
  {
    foreach ($this->val as $value) {
      if (gettype($value) === 'array') return false;
    }

    return true;
  }
}
