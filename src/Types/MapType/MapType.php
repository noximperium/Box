<?php

namespace NoxImperium\Box\Types\MapType;

use Exception;
use NoxImperium\Box\Types\ListType\ListType;

class MapType
{
  private $val;

  public function __construct($val)
  {
    $this->val = $val;
  }

  public function containsKey($key)
  {
    foreach ($this->val as $mapKey => $_) {
      if ($mapKey === $key) return true;
    }

    return false;
  }

  public function containsValue($value)
  {
    foreach ($this->val as $mapValue) {
      if ($mapValue === $value) return true;
    }

    return false;
  }

  public function containsPath($path)
  {
    if (gettype($path) === 'string') $path = explode('.', $path);

    $ref = $this->val;

    foreach ($path as $key) {
      if (!isset($ref[$key])) return false;
      else $ref = $ref[$key];
    }

    return true;
  }

  public function forEach($action)
  {
    foreach ($this->val as $value) {
      $action($value);
    }
  }

  public function forEachKeyed($action)
  {
    foreach ($this->val as $key => $value) {
      $action($key, $value);
    }
  }

  public function get($key)
  {
    return $this->val[$key];
  }

  public function getOrNull($key)
  {
    return $this->val[$key] ?? null;
  }

  public function getOrElse($key, $default)
  {
    return $this->val[$key] ?? $default;
  }

  public function getOnPath($path)
  {
    $onNotFound = function () {
      throw new Exception('Path not found.');
    };

    return $this->pathGetter($path, $onNotFound, $this->val);
  }

  public function getOnPathOrNull($path)
  {
    $onNotFound = function () {
      return null;
    };

    return $this->pathGetter($path, $onNotFound, $this->val);
  }

  public function getOnPathOrElse($path, $default)
  {
    $onNotFound = function () use ($default) {
      return $default;
    };

    return $this->pathGetter($path, $onNotFound, $this->val);
  }

  public function getOnPaths($paths)
  {
    $result = [];
    foreach ($paths as $path) {
      $result[] = $this->getOnPathOrNull($path, $this->val);
    }

    return new ListType($result);
  }

  public function keys()
  {
    return new ListType(array_keys($this->val));
  }

  public function mergeLeft($other)
  {
    $result = $this->val;
    foreach ($other as $key => $value) {
      $exists = isset($result[$key]);
      if (!$exists) $result[$key] = $value;
    }

    return new MapType($result);
  }

  public function mergeDeepLeft($other)
  {
    $this->_mergeDeepLeft($this->val, $other);

    return new MapType($this->val);
  }

  public function mergeRight($other)
  {
    $result = $this->val;
    foreach ($other as $key => $value) {
      $result[$key] = $value;
    }

    return new MapType($result);
  }

  public function mergeDeepRight($other)
  {
    $this->_mergeDeepRight($this->val, $other);

    return new MapType($this->val);
  }

  public function mergeWith($transform, $other)
  {
    $result = $this->val;
    foreach ($other as $key => $value) {
      if (isset($result[$key])) $result[$key] = $transform($result[$key], $value);
      else $result[$key] = $value;
    }

    return new MapType($result);
  }

  public function mergeDeepWith($transform, $other)
  {
    $this->_mergeDeepWith($transform, $this->val, $other);

    return new MapType($this->val);
  }

  public function modify($key, $transform)
  {
    $isKeyExists = isset($this->val[$key]);;
    if (!$isKeyExists) return $this;

    $newMap = $this->val;
    $newMap[$key] = $transform($newMap[$key]);

    return new MapType($newMap);
  }

  public function modifyOnPath($path, $transform)
  {
    if (gettype($path) === 'string') $path = explode('.', $path);

    $lastIndex = count($path) - 1;
    $newMap = $this->val;
    $ref = &$newMap;

    foreach ($path as $index => $key) {
      $isKeyExists = isset($ref[$key]);
      if (!$isKeyExists) return $this;

      $isLastIndex = $index === $lastIndex;
      if ($isLastIndex) $ref[$key] = $transform($ref[$key]);
      else $ref = &$ref[$key];
    }

    return new MapType($newMap);
  }

  public function omit($paths)
  {
    foreach ($paths as $key) {
      unset($this->val[$key]);
    }

    return new MapType($this->val);
  }

  public function onEach($action)
  {
    foreach ($this->val as $value) {
      $action($value);
    }

    return $this;
  }

  public function onEachKeyed($action)
  {
    foreach ($this->val as $key => $value) {
      $action($key, $value);
    }

    return $this;
  }

  public function put($key, $value)
  {
    $isExists = isset($this->val[$key]);
    if (!$isExists) $this->val += [$key => $value];
    else $this->val[$key] = $value;

    return new ListType($this->val);
  }

  public function putOnPath($path, $value)
  {
    if (gettype($path) === 'string') $path = explode('.', $path);

    $ref = &$this->val;
    $length = count($path);

    foreach ($path as $index => $key) {
      $keyExists = isset($ref[$key]);
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

    return new MapType($this->val);
  }

  public function remove($key)
  {
    unset($this->val[$key]);

    return new MapType($this->val);
  }

  public function removeOnPath($path)
  {
    if (gettype($path) === 'string') $path = explode('.', $path);

    $ref = &$this->val;
    $length = count($path);

    foreach ($path as $index => $key) {
      $isLastIndex = $index === $length - 1;

      if ($isLastIndex) unset($ref[$key]);
      else $ref = &$ref[$key];
    }

    return new MapType($this->val);
  }

  public function tap($action)
  {
    $action($this->val);

    return $this;
  }

  public function val()
  {
    return $this->val;
  }

  public function values()
  {
    return new ListType(array_values($this->val));
  }

  private function _mergeDeepLeft(&$map, $other)
  {
    $result = &$map;
    foreach ($other as $key => $value) {
      $leftExists = isset($result[$key]);
      $bothArray = $leftExists ? gettype($result[$key]) === 'array' && gettype($value) === 'array' : false;

      if ($leftExists && $bothArray) $this->_mergeDeepLeft($map[$key], $value);
      else if (!$leftExists) $result[$key] = $value;
    }
  }

  private function _mergeDeepRight(&$map, $other)
  {
    $result = &$map;
    foreach ($other as $key => $value) {
      $leftExists = isset($result[$key]);
      $bothArray = $leftExists ? gettype($result[$key]) === 'array' && gettype($value) === 'array' : false;

      if ($leftExists && $bothArray) $this->_mergeDeepRight($map[$key], $value);
      else $result[$key] = $value;
    }
  }

  private function _mergeDeepWith($transform, &$map, $other)
  {
    $result = &$map;
    foreach ($other as $key => $value) {
      $leftExists = isset($result[$key]);
      $bothArray = $leftExists ? gettype($result[$key]) === 'array' && gettype($value) === 'array' : false;

      if ($leftExists && $bothArray) $this->_mergeDeepWith($transform, $map[$key], $value);
      else if ($leftExists) $result[$key] = $transform($result[$key], $value);
      else $result[$key] = $value;
    }
  }

  private function pathGetter($path, $onNotFound, $map)
  {
    if (gettype($path) === 'string') $path = explode('.', $path);

    $value = $map;

    foreach ($path as $key) {
      $exists = array_key_exists($key, $value);

      if (!$exists) return $onNotFound();
      $value = $value[$key];
    }

    return $value;
  }
}
