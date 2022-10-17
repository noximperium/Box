<?php

namespace NoxImperium\Container;

use NoxImperium\Container\Interfaces\BaseMap;

class MutableMap implements BaseMap
{
  private $val;
  private $mapFunction;

  public function __construct($val)
  {
    $this->val = $val;
    $this->mapFunction = new MapFunction();
  }

  public function all($predicate)
  {
    return $this->mapFunction->all($predicate, $this->val);
  }

  public function any($predicate)
  {
    return $this->mapFunction->any($predicate, $this->val);
  }

  public function containsKey($key)
  {
    return $this->mapFunction->containsKey($key, $this->val);
  }

  public function containsValue($value)
  {
    return $this->mapFunction->containsKey($value, $this->val);
  }

  public function containsPath($path)
  {
    return $this->mapFunction->containsKey($path, $this->val);
  }

  public function forEach($action)
  {
    $this->mapFunction->forEach($action, $this->val);
  }

  public function forEachKeyed($action)
  {
    $this->mapFunction->forEachKeyed($action, $this->val);
  }

  public function get($key)
  {
    return $this->mapFunction->get($key, $this->val);
  }

  public function getOrNull($key)
  {
    return $this->mapFunction->getOrNull($key, $this->val);
  }

  public function getOrElse($key, $default)
  {
    return $this->mapFunction->getOrElse($key, $default, $this->val);
  }

  public function getOnPath($path)
  {
    return $this->mapFunction->getOnPath($path, $this->val);
  }

  public function getOnPathOrNull($path)
  {
    return $this->mapFunction->getOnPathOrNull($path, $this->val);
  }

  public function getOnPathOrElse($path, $default)
  {
    return $this->mapFunction->getOnPathOrElse($path, $default, $this->val);
  }

  public function getOnPaths($paths)
  {
    return $this->mapFunction->getOnPath($paths, $this->val);
  }

  public function keys()
  {
    return $this->mapFunction->keys($this->val);
  }

  public function mergeLeft($other)
  {
    $this->val = $this->mapFunction->mergeLeft($this->val, $other);

    return $this;
  }

  public function mergeDeepLeft($other)
  {
    $this->val = $this->mapFunction->mergeDeepLeft($this->val, $other);

    return $this;
  }

  public function mergeRight($other)
  {
    $this->val = $this->mapFunction->mergeRight($this->val, $other);

    return $this;
  }

  public function mergeDeepRight($other)
  {
    $this->val = $this->mapFunction->mergeDeepRight($this->val, $other);

    return $this;
  }

  // TO BE IMPLEMENTED LATER
  public function mergeWith($map)
  {
  }

  // TO BE IMPLEMENTED LATER
  public function mergeDeepWith($map)
  {
  }

  public function modify($key, $transform)
  {
    $this->val = $this->mapFunction->modify($key, $transform, $this->val);

    return $this;
  }

  public function modifyPath($path, $transform)
  {
    $this->val = $this->mapFunction->modifyPath($path, $transform, $this->val);

    return $this;
  }

  public function none($predicate)
  {
    return $this->mapFunction->none($predicate, $this->val);
  }

  public function omit($paths)
  {
    $this->val = $this->mapFunction->omit($paths, $this->val);

    return $this;
  }

  public function onEach($action)
  {
    $this->mapFunction->forEach($action, $this->val);

    return $this;
  }

  public function onEachKeyed($action)
  {
    $this->mapFunction->forEachKeyed($action, $this->val);

    return $this;
  }

  public function put($key, $value)
  {
    $this->val = $this->mapFunction->put($key, $value, $this->val);

    return $this;
  }

  public function putOnPath($path, $value)
  {
    $this->val = $this->mapFunction->putOnPath($path, $value, $this->val);

    return $this;
  }

  public function remove($key)
  {
    $this->val = $this->mapFunction->remove($key, $this->val);

    return $this;
  }

  public function removeOnPath($path)
  {
    $this->val = $this->mapFunction->removeOnPath($path, $this->val);

    return $this;
  }

  public function val()
  {
    return $this->val;
  }

  public function values()
  {
    return $this->mapFunction->values($this->val);
  }
}
