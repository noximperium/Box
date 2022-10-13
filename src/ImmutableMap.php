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

  public static function of($init)
  {
    return new ImmutableMap($init);
  }

  public function keys()
  {
    return array_keys($this->val);
  }

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

  /**
   * Associates the specified value with the specified key in the map.
   * @return mixed Return the previous value associated with the key, or null if the key was not present in the map.
   */
  public function put($key, $value)
  {
    $isExists = array_key_exists($key, $this->val);
    if (!$isExists) return null;

    $currentValue = $this->val[$key];
    $this->val[$key] = $value;
  }

  public function toPath($path)
  {
    $newAssoc = $this->val;

    foreach ($path as $key) {
      $exists = array_key_exists($key, $newAssoc);

      if (!$exists) throw new Exception("Assoc with key '$key' doesn't exists.");
      $newAssoc = $newAssoc[$key];
    }

    $this->val = $newAssoc;
  }

  public function val()
  {
    return $this->val;
  }
}
