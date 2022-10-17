<?php

namespace NoxImperium\Box\Functions;

use Exception;

class MapFunction
{
  public function all($predicate, $map)
  {
    foreach ($map as $key => $value) {
      if (!$predicate($value, $key)) return false;
    }

    return true;
  }

  public function any($predicate, $map)
  {
    foreach ($map as $key => $value) {
      if ($predicate($value, $key)) return true;
    }

    return false;
  }

  public function containsKey($key, $map)
  {
    foreach ($map as $mapKey => $value) {
      if ($mapKey === $key) return true;
    }

    return false;
  }

  public function containsValue($value, $map)
  {
    foreach ($map as $mapValue) {
      if ($mapValue === $value) return true;
    }

    return false;
  }

  public function containsPath($path, $map)
  {
    if (gettype($path) === 'string') $path = explode('.', $path);

    $ref = $this->val;

    foreach ($path as $key) {
      if (!isset($ref[$key])) return false;
      else $ref = $ref[$key];
    }

    return true;
  }

  public function forEach($action, $map)
  {
    foreach ($map as $value) {
      $action($value);
    }
  }

  public function forEachKeyed($action, $map)
  {
    foreach ($map as $key => $value) {
      $action($key, $value);
    }
  }

  public function get($key, $map)
  {
    return $map[$key];
  }

  public function getOrNull($key, $map)
  {
    return $map[$key] ?? null;
  }

  public function getOrElse($key, $default, $map)
  {
    return $map[$key] ?? $default;
  }

  public function getOnPath($path, $map)
  {
    $onNotFound = function () {
      throw new Exception('Path not found.');
    };

    return $this->pathGetter($path, $onNotFound, $map);
  }

  public function getOnPathOrNull($path, $map)
  {
    $onNotFound = function () {
      return null;
    };

    return $this->pathGetter($path, $onNotFound, $map);
  }

  public function getOnPathOrElse($path, $default, $map)
  {
    $onNotFound = function () use ($default) {
      return $default;
    };

    return $this->pathGetter($path, $onNotFound, $map);
  }

  public function getOnPaths($paths, $map)
  {
    $result = [];
    foreach ($paths as $path) {
      $result[] = $this->getOnPathOrNull($path, $map);
    }

    return $result;
  }

  public function keys($map)
  {
    return array_keys($map);
  }

  public function mergeLeft($map, $other)
  {
    $result = $map;
    foreach ($other as $key => $value) {
      $exists = isset($result[$key]);
      if (!$exists) $result[$key] = $value;
    }

    return $result;
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

  public function mergeDeepLeft($map, $other)
  {
    $this->_mergeDeepLeft($map, $other);
    return $map;
  }

  public function mergeRight($map, $other)
  {
    $result = $map;
    foreach ($other as $key => $value) {
      $result[$key] = $value;
    }

    return $result;
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


  public function mergeDeepRight($map, $other)
  {
    $this->_mergeDeepRight($map, $other);
    return $map;
  }

  // TO BE IMPLEMENTED LATER
  public function mergeWith($transform, $map, $other)
  {
  }

  // TO BE IMPLEMENTED LATER
  public function mergeDeepWith($transform, $other, $map)
  {
  }

  public function modify($key, $transform, $map)
  {
    $isKeyExists = isset($map[$key]);;
    if (!$isKeyExists) return $map;

    $newMap = $map;
    $newMap[$key] = $transform($newMap[$key]);

    return $newMap;
  }

  public function modifyPath($path, $transform, $map)
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

    return $newMap;
  }

  public function none($predicate, $map)
  {
    foreach ($map as $key => $value) {
      if ($predicate($value, $key)) return false;
    }

    return true;
  }

  public function omit($keys, $map)
  {
    foreach ($keys as $key) {
      unset($map[$key]);
    }

    return $map;
  }

  public function put($key, $value, $map)
  {
    $isExists = isset($map[$key]);
    if (!$isExists) $this->val += [$key => $value];
    else $this->val[$key] = $value;

    return $map;
  }

  public function putOnPath($path, $value, $map)
  {
    if (gettype($path) === 'string') $path = explode('.', $path);

    $ref = &$map;
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

    return $map;
  }

  public function remove($key, $map)
  {
    unset($map[$key]);

    return $map;
  }

  public function removeOnPath($path, $map)
  {
    if (gettype($path) === 'string') $path = explode('.', $path);

    $ref = &$map;
    $length = count($path);

    foreach ($path as $index => $key) {
      $isLastIndex = $index === $length - 1;

      if ($isLastIndex) unset($ref[$key]);
      else $ref = &$ref[$key];
    }
  }

  public function values($map)
  {
    return array_values($map);
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
