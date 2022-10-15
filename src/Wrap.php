<?php

namespace NoxImperium\Container;

use Exception;

class Wrap
{
  private $val;

  function __construct($val)
  {
    $this->val = $val;
  }

  public static function of(...$args)
  {
    return new Wrap([...$args]);
  }

  public static function from($val)
  {
    return new Wrap($val);
  }

  /**
   * Update a value at specified path with the result of the provided function. 
   */
  public function adjust($path, $bifunction)
  {
    $val = $this->val;
    $ref = &$val;

    $pair = $this->getRefOnPath($ref, $path);
    $pair['ref'] = $bifunction($pair['ref'], $pair['key']);

    return new Wrap($val);
  }

  /**
   * Returns true if all elements of the `Wrap` match the predicate, false otherwise.
   * @param callable $bipredicate (value, key) -> boolean
   */
  public function all($bipredicate)
  {
    foreach ($this->val as $index => $value) {
      if (!$bipredicate($value, $index)) return false;
    }

    return true;
  }

  /**
   * Returns true if at least one of the elements of the list match the predicate, false otherwise.
   * @param callable $bipredicate (value, key) -> boolean
   */
  public function any($bipredicate)
  {
    foreach ($this->val as $item) {
      if ($bipredicate($item)) return true;
    }

    return false;
  }


  public function val()
  {
    return $this->val;
  }

  private function toPath($value)
  {
    $type = gettype($value);

    if ($type === 'string') {
      $containsDot = strpos($value, '.');
      if ($containsDot !== false) return explode('.', $value);
    }

    if ($type === 'array') return $value;

    return [$value];
  }

  private function getRefOnPath(&$ref, $path)
  {
    $path = $this->toPath($path);

    $refs = [&$ref];
    $lastKey = $path[count($path) - 1];

    foreach ($path as $index => $key) {
      $exists = array_key_exists($key, $refs[$index]);

      if (!$exists) throw new Exception('Path not found.');
      $refs[] = &$refs[$index][$key];
    }

    return [
      'key' => $lastKey,
      'ref' => &$refs[count($refs) - 1]
    ];
  }
}
