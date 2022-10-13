<?php

namespace NoxImperium\Container;

use Exception;

class ImmutableMap
{
  private $val;

  private function __construct($init)
  {
    $this->val = $init;
  }

  /**
   * Returns an instance of ImmutableMap with passed initial value.
   * @param array $init An initial value.
   * @return ImmutableMap A new instance of ImmutableMap
   */
  public static function of($init = [])
  {
    if (gettype($init) !== 'array') throw new Exception('Initial value must be an array');

    return new ImmutableMap($init);
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
   * Makes a clone of a map, setting or overriding the specified property with the given value. 
   * @param String $key A key to set
   * @param mixed $value The new value
   * @return ImmutableMap A new map equivalent to the original except for the changed property.
   */
  public function assoc($key, $value)
  {
    $isExists = array_key_exists($key, $this->val);
    if (!$isExists) $this->val += [$key => $value];
    else $this->val[$key] = $value;

    return new ImmutableMap($this->val);
  }

  /**
   * Makes a clone of a map, setting or overriding the nodes required to create the given path, and placing the specific value at the tail end of that path. 
   * @param array|String $path The path to set. If path is string, node should be separated by dot.
   * @param mixed $value The new value
   * @return ImmutableMap A new map equivalent to the original except along the specified path.
   */
  public function assocPath($path, $value)
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

    return new ImmutableMap($this->val);
  }

  /**
   * Returns a new map that does not contain the specified key.
   * @param $key The key to dissociate
   * @return ImmutableMap A new map equivalent to the original but without the specified property
   */
  public function dissoc($key)
  {
    unset($this->val[$key]);

    return new ImmutableMap($this->val);
  }

  /**
   * Makes a clone of an object, omitting the property at the given path.
   * @param array|String $path The path to the value to omit
   * @return ImmutableMap A new object without the property at path.
   */
  public function dissocPath($path)
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

    return new ImmutableMap($temp);
  }

  /** CHANGE DOC
   * Groups values returned by the valueTransform function (if passed) applied to each element of the original collection 
   * by the key returned by the given keySelector function applied to the element and 
   * returns a map where each group key is associated with a list of corresponding values.
   * @param callable $keyTransform
   * @param callable $valueTransform
   * @return ImmutableMap 
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

    return ImmutableMap::of($result);
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

    return ImmutableMap::of($result);
  }

  /**
   * Returns whether or not an object has an own property with the specified name.
   * @param String $key A key to check.
   * @return boolean Whether or not an object has an own property with the specified name.
   */
  public function has($key)
  {
    return array_key_exists($key, $this->val);
  }

  /**
   * Returns whether or not a path exists in a map.
   * @param array|String $path A path to check.
   * @return boolean Whether or not a path exists in a map.
   */
  public function hasPath($path)
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
   * Returns a new instance of ImmutableArray by running `$transform` through `ImmutableMap` values. 
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
   * Returns a new `ImmutableMap` with entries having the keys obtained by 
   * applying the transform function to each entry in this `ImmutableMap` and the values of this `ImmutableMap`.
   */
  public function mapKeys($transform)
  {
    $map = [];

    foreach ($this->val as $key => $value) {
      $key = $transform($key, $value);
      $map[$key] = $value;
    }

    return new ImmutableMap($map);
  }

  /**
   * Returns a new `ImmutableMap` with entries having the keys of this map 
   * and the values obtained by applying the transform function to each entry in this `ImmutableMap`.
   */
  public function mapValues($transform)
  {
    $map = [];

    foreach ($this->val as $key => $value) {
      $map[$key] = $transform($key, $value);
    }

    return new ImmutableMap($map);
  }

  /**
   * Returns a new `ImmutableMap` with entries having the keys obtained by 
   * applying the `$keyTransform` function to each entry and the values obtained by 
   * applying the `$valueTransform` function to each entry in this `ImmutableMap`.
   */
  public function mapKeysValues($keyTransform, $valueTransform)
  {
    $map = [];

    foreach ($this->val as $key => $value) {
      $entryKey = $keyTransform($key, $value);
      $entryValue = $valueTransform($key, $value);
      $map[$entryKey] = $entryValue;
    }

    return new ImmutableMap($map);
  }

  /**
   * Creates a copy of the passed object by applying an fn function to the given key property.
   * @param String $key Key to target.
   * @param callable $fn Function to apply to the property.
   * @return ImmutableMap The transformed map.
   */
  public function modify($key, $fn)
  {
    $isKeyExists = array_key_exists($key, $this->val);
    if (!$isKeyExists) return $this;

    $new = $this->val;
    $new[$key] = $fn($new[$key]);
    return new ImmutableMap($new);
  }

  /**
   * Creates a clone of current ImmutableMap by applying an fn function to the value at the given path.
   * @param array|String $path Path to property.
   * @param $fn Function to apply to the property.
   * @return ImmutableMap The transformed map.
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

    return new ImmutableMap($new);
  }

  /**
   * Returns a copy of this ImmutableMap with omitted keys specified.
   * @param array $keys Keys to omit.
   * @return ImmutableMap The transformed map.
   */
  public function omit($keys)
  {
    $new = $this->val;

    foreach ($keys as $key) {
      unset($new[$key]);
    }

    return new ImmutableMap($new);
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
  public function pathOr($path, $default)
  {
    $pathValue = $this->path($path);

    return $pathValue ?? $default;
  }

  /**
   * Returns a copy of `ImmutableMap` containing only the keys specified. 
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

    return new ImmutableMap($result);
  }

  /**
   * Returns current value of ImmutableMap
   * @return array Value of this ImmutableMap
   */
  public function val()
  {
    return $this->val;
  }
}
