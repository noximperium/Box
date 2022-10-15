<?php

namespace NoxImperium\Container;

use Exception;

class ImmutableAssoc
{
  private $val;

  private function __construct($init)
  {
    $this->val = $init;
  }

  /**
   * Returns an instance of ImmutableAssoc with passed initial value.
   * @param array $init An initial value.
   * @return ImmutableAssoc A new instance of ImmutableAssoc
   */
  public static function of($init = [])
  {
    if (gettype($init) !== 'array') throw new Exception('Initial value must be an array');

    return new ImmutableAssoc($init);
  }

  /**
   * Returns an array of all keys in this map.
   */
  public function keys()
  {
    return array_keys($this->val);
  }

  /**
   * Returns an array of all values in this map.
   */
  public function values()
  {
    return array_values($this->val);
  }

  /**
   * Update a value at a specific key with the result of the provided function. 
   * @param int $index The index.
   * @param callable $fn The function to apply.
   * @return ImmutableArray A copy of the supplied array-like object with the element at index `$idx` replaced with the value returned by applying `$fn` to the existing element.
   */
  public function adjust($key, $function)
  {
    $exists = array_key_exists($key, $this->val);
    if (!$exists) throw new Exception('Key not found.');

    $this->val[$key] = $function($this->val[$key]);

    return new ImmutableAssoc($this->val);
  }


  /**
   * Returns true if all entries match the given predicate.
   * @param callable $predicate (value, key) => boolean
   * @return boolean `true` if the predicate is satisfied by every element, `false` otherwise.
   */
  public function all($predicate)
  {
    foreach ($this->val as $key => $value) {
      if (!$predicate($value, $key)) return false;
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
    foreach ($this->val as $key => $value) {
      if ($predicate($value, $key)) return true;
    }

    return false;
  }

  /**
   * Checks if the specified path is contained in this `ImmutableAssoc`.
   * @param array|String $path A path to check.
   * @return boolean Whether or not a path exists in a map.
   */
  public function containsPath($path)
  {
    if (gettype($path) === 'string') $path = explode('.', $path);

    $ref = $this->val;

    foreach ($path as $key) {
      if (!array_key_exists($key, $ref)) return false;
      else $ref = $ref[$key];
    }

    return true;
  }

  /**
   * Returns a new map containing all key-value pairs matching the given predicate.
   * @param callable $predicate A predicate used to test whether the element should be included.
   * @return ImmutableAssoc A new array with only element that satisfy `$predicate`.
   */
  public function filter($predicate)
  {
    $result = [];

    foreach ($this->val as $key => $value) {
      $eligible = $predicate($value, $key);
      if ($eligible) $result[$key] = $value;
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

    foreach ($this->val as $key => $value) {
      $eligible = !$predicate($value, $key);
      if ($eligible) $result[$key] = $value;
    }

    return new ImmutableArray($result);
  }

  /**
   * Returns a map containing all key-value pairs with keys matching the given predicate.
   * @param callable $predicate A predicate used to test whether the element should be included.
   * @return ImmutableArray A new array with only element that dissatisfy `$predicate`.
   */
  public function filterKeys($predicate)
  {
    $result = [];

    foreach ($this->val as $key => $value) {
      $eligible = !$predicate($key);
      if ($eligible) $result[$key] = $value;
    }

    return new ImmutableArray($result);
  }

  /**
   * Returns a map containing all key-value pairs with values matching the given predicate.
   * @param callable $predicate A predicate used to test whether the element should be included.
   * @return ImmutableArray A new array with only element that dissatisfy `$predicate`.
   */
  public function filterValues($predicate)
  {
    $result = [];

    foreach ($this->val as $key => $value) {
      $eligible = !$predicate($value);
      if ($eligible) $result[$key] = $value;
    }

    return new ImmutableArray($result);
  }

  /** CHANGE DOC
   * Groups values returned by the valueTransform function (if passed) applied to each element of the original collection 
   * by the key returned by the given keySelector function applied to the element and 
   * returns a map where each group key is associated with a list of corresponding values.
   * @param callable $keyTransform
   * @param callable $valueTransform
   * @return ImmutableAssoc 
   */
  public function groupBy($keyTransform, $valueTransform = null)
  {
    $result = [];

    foreach ($this->val as $key => $value) {
      if ($valueTransform) $value = $valueTransform($key, $value);
      $key = $keyTransform($key, $value);
      $keyExists = array_key_exists($key, $result);

      if ($keyExists) $result[$key][] = $value;
      else $result += [$key => [$value]];
    }

    return ImmutableAssoc::of($result);
  }

  public function groupByKeyed($groupKeyTransform, $keyTransform, $valueTransform = null)
  {
    $result = [];

    foreach ($this->val as $key => $value) {
      $keyOnGroup = $keyTransform($key, $value);
      $groupKey = $groupKeyTransform($key, $value);
      if ($valueTransform) $value = $valueTransform($key, $value);

      $groupKeyExists = array_key_exists($groupKey, $result);
      if ($groupKeyExists) $result[$groupKey][$keyOnGroup] = $value;
      else $result += [$groupKey => [$keyOnGroup => $value]];
    }

    return ImmutableAssoc::of($result);
  }

  /**
   * Returns a new instance of ImmutableArray by running `$transform` through `ImmutableAssoc` values. 
   * @param callable $transform Function to apply to each element. ($key, $value) => mixed.
   */
  public function map($transform)
  {
    $array = [];

    foreach ($this->val as $key => $value) {
      $array[] = $transform($key, $value);
    }

    return ImmutableArray::of($array);
  }

  /**
   * Returns a new `ImmutableAssoc` with entries having the keys obtained by 
   * applying the transform function to each entry in this `ImmutableAssoc` and the values of this `ImmutableAssoc`.
   */
  public function mapKeys($transform)
  {
    $map = [];

    foreach ($this->val as $key => $value) {
      $key = $transform($key, $value);
      $map[$key] = $value;
    }

    return new ImmutableAssoc($map);
  }

  /**
   * Returns a new `ImmutableAssoc` with entries having the keys of this map 
   * and the values obtained by applying the transform function to each entry in this `ImmutableAssoc`.
   */
  public function mapValues($transform)
  {
    $map = [];

    foreach ($this->val as $key => $value) {
      $map[$key] = $transform($key, $value);
    }

    return new ImmutableAssoc($map);
  }

  /**
   * Returns a new `ImmutableAssoc` with entries having the keys obtained by 
   * applying the `$keyTransform` function to each entry and the values obtained by 
   * applying the `$valueTransform` function to each entry in this `ImmutableAssoc`.
   */
  public function mapKeysValues($keyTransform, $valueTransform)
  {
    $map = [];

    foreach ($this->val as $key => $value) {
      $entryKey = $keyTransform($key, $value);
      $entryValue = $valueTransform($key, $value);
      $map[$entryKey] = $entryValue;
    }

    return new ImmutableAssoc($map);
  }

  /**
   * Creates a copy of the passed object by applying an fn function to the given key property.
   * @param String $key Key to target.
   * @param callable $fn Function to apply to the property.
   * @return ImmutableAssoc The transformed map.
   */
  public function modify($key, $fn)
  {
    $isKeyExists = array_key_exists($key, $this->val);
    if (!$isKeyExists) return $this;

    $new = $this->val;
    $new[$key] = $fn($new[$key]);
    return new ImmutableAssoc($new);
  }

  /**
   * Creates a clone of current ImmutableAssoc by applying an fn function to the value at the given path.
   * @param array|String $path Path to property.
   * @param $fn Function to apply to the property.
   * @return ImmutableAssoc The transformed map.
   */
  public function modifyPath($path, $fn)
  {
    if (gettype($path) === 'string') $path = explode('.', $path);

    $lastIndex = count($path) - 1;
    $new = $this->val;
    $ref = &$new;

    foreach ($path as $index => $key) {
      $isKeyExists = array_key_exists($key, $ref);
      if (!$isKeyExists) return $this;

      $isLastIndex = $index === $lastIndex;
      if ($isLastIndex) $ref[$key] = $fn($ref[$key]);
      else $ref = &$ref[$key];
    }

    return new ImmutableAssoc($new);
  }

  /**
   * Returns a copy of this ImmutableAssoc with omitted keys specified.
   * @param array $keys Keys to omit.
   * @return ImmutableAssoc The transformed map.
   */
  public function omit($keys)
  {
    $new = $this->val;

    foreach ($keys as $key) {
      unset($new[$key]);
    }

    return new ImmutableAssoc($new);
  }

  /**
   * Performs the given action on each element and returns the collection itself afterwards.
   */
  public function onEach($action)
  {
    foreach ($this->val as $key => $value) {
      $action($value, $key);
    }

    return $this;
  }


  /**
   * Retrieve the value at a given path.
   * @param array|String $path Path to property.
   * @return mixed Property on `$path`.
   */
  public function path($path)
  {
    if (gettype($path) === 'string') $path = explode('.', $path);

    $newValue = $this->val;

    foreach ($path as $key) {
      $exists = array_key_exists($key, $newValue);

      if (!$exists) return null;
      $newValue = $newValue[$key];
    }

    return $newValue;
  }

  /**
   * Determines whether a nested path on the map has a specific value.
   * @param array|String $path Path to property.
   * @param mixed $value Value to check.
   * @return boolean Whether the value on path is equal with `$value`.
   */
  public function pathEq($path, $value)
  {
    $pathValue = $this->path($path);

    return $pathValue === $value;
  }

  /**
   * Returns the value at that path if available. Otherwise returns the provided default value.
   * @param array|String $path Path to property.
   * @param mixed $default The default value.
   * @return mixed Value at specified path or null.
   */
  public function pathOrElse($path, $default)
  {
    $pathValue = $this->path($path);

    return $pathValue ?? $default;
  }

  /**
   * Returns the value at that path if available. Otherwise returns the provided default value.
   * @param array|String $path Path to property.
   * @param mixed $default The default value.
   * @return mixed Value at specified path or null.
   */
  public function pathOrNull($path)
  {
    $pathValue = $this->path($path);

    return $pathValue ?? null;
  }


  /**
   * Retrieves the values at given paths of an object.
   * @param array|String $paths Paths to property.
   */
  public function paths($paths)
  {
    $paths = array_map(function ($path) {
      if (gettype($path) === 'string') return explode('.', $path);
      else return $path;
    }, $paths);

    $result = [];
    foreach ($paths as $path) {
      $result[] = $this->pathOrNull($path);
    }

    return ImmutableArray::of($result);
  }

  /**
   * Returns a copy of `ImmutableAssoc` containing only the keys specified. 
   * If the key does not exist, the property is ignored.
   */
  public function pick($keys)
  {
    $result = [];

    foreach ($keys as $key) {
      if (array_key_exists($key, $this->val)) {
        $result[$key] = $this->val[$key];
      }
    }

    return new ImmutableAssoc($result);
  }

  /**
   * Returns a new map that does not contain the specified key.
   * @param $key The key to dissociate
   * @return ImmutableAssoc A new map equivalent to the original but without the specified property
   */
  public function remove($key)
  {
    unset($this->val[$key]);

    return new ImmutableAssoc($this->val);
  }

  /**
   * Makes a clone of an object, omitting the property at the given path.
   * @param array|String $path The path to the value to omit
   * @return ImmutableAssoc A new object without the property at path.
   */
  public function removePath($path)
  {
    if (gettype($path) === 'string') $path = explode('.', $path);

    $temp = $this->val;
    $ref = &$temp;
    $length = count($path);

    foreach ($path as $index => $key) {
      $isLastIndex = $index === $length - 1;

      if ($isLastIndex) unset($ref[$key]);
      else $ref = &$ref[$key];
    }

    return new ImmutableAssoc($temp);
  }

  /**
   * Makes a clone of a map, setting or overriding the specified property with the given value. 
   * @param String $key A key to set
   * @param mixed $value The new value
   * @return ImmutableAssoc A new map equivalent to the original except for the changed property.
   */
  public function put($key, $value)
  {
    $isExists = array_key_exists($key, $this->val);
    if (!$isExists) $this->val += [$key => $value];
    else $this->val[$key] = $value;

    return new ImmutableAssoc($this->val);
  }

  /**
   * Makes a clone of a map, setting or overriding the nodes required to create the given path, and placing the specific value at the tail end of that path. 
   * @param array|String $path The path to set. If path is string, node should be separated by dot.
   * @param mixed $value The new value
   * @return ImmutableAssoc A new map equivalent to the original except along the specified path.
   */
  public function putPath($path, $value)
  {
    if (gettype($path) === 'string') $path = explode('.', $path);

    $ref = &$this->val;
    $length = count($path);

    foreach ($path as $index => $key) {
      $keyExists = array_key_exists($key, $ref);
      $isLastIndex = $index === $length - 1;

      // Key creation
      if (!$keyExists && !$isLastIndex) {
        $ref += [$key => []];
        $ref = &$ref[$key];
        continue;
      }

      // Key creation
      if ($keyExists && !$isLastIndex) {
        $ref = &$ref[$key];
        continue;
      }

      // Value assignment
      if ($isLastIndex && !$keyExists) $ref += [$key => $value];
      else if ($isLastIndex && $keyExists) $ref[$key] = $value;
    }

    return new ImmutableAssoc($this->val);
  }


  /**
   * Runs the given function with the supplied object, then returns the object.
   */
  public function tap($fn)
  {
    $fn($this->val);

    return $this;
  }

  /**
   * Returns current value of ImmutableAssoc
   * @return array Value of this ImmutableAssoc
   */
  public function val()
  {
    return $this->val;
  }
}
