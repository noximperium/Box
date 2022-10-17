<?php

namespace NoxImperium\Container;

use Exception;
use NoxImperium\Container\Interfaces\BaseList;

// TODO
// Change all array_key_exists with isset

class BaseListImpl implements BaseList
{
  protected $val;

  protected function __construct($val)
  {
    $this->val = $val;
  }

  public function all($predicate)
  {
    foreach ($this->val as $item) {
      if (!$predicate($item)) return false;
    }

    return true;
  }

  public function any($predicate)
  {
    foreach ($this->val as $item) {
      if ($predicate($item)) return true;
    }

    return false;
  }

  public function append($value)
  {
    $this->val[] = $value;
  }

  public function appendAll($list)
  {
    array_push($this->val, ...$list);
  }

  public function average()
  {
    return array_sum($this->val) / count($this->val);
  }

  public function contains($element)
  {
    foreach ($this->val as $value) {
      if ($element === $value) return true;
    }

    return false;
  }

  public function containsAll($values)
  {
    foreach ($values as $value) {
      if (!in_array($value, $this->val)) return false;
    }

    return true;
  }

  public function collectBy($keySelector)
  {
    $result = [];

    foreach ($this->val as $value) {
      $key = $keySelector($value);
      if (isset($result[$key])) $result[$key][] = $value;
      else $result[$key] = [$value];
    }

    $this->val = array_values($result);
  }

  public function count($predicate)
  {
    $count = 0;
    foreach ($this->val as $value) {
      if ($predicate($value)) $count++;
    }

    return $count;
  }

  public function distinct()
  {
    $result = [];
    foreach ($this->val as $value) {
      if (!in_array($value, $result)) $result[] = $value;
    }

    $this->val = $result;
  }

  public function distinctBy($keySelector)
  {
    $result = [];
    $determiners = [];

    foreach ($this->val as $value) {
      $determiner = $keySelector($value);

      if (!in_array($determiner, $determiners)) {
        $determiners[] = $determiner;
        $result[] = $value;
      }
    }

    $this->val = $result;
  }

  public function drop($n)
  {
    $result = array_slice($this->val, $n);

    $this->val = $result;
  }

  public function dropWhile($predicate)
  {
    $result = [];

    foreach ($this->val as $value) {
      if (!$predicate($value)) $result[] = $value;
    }

    $this->val = $result;
  }

  public function dropLast($n)
  {
    $result = array_slice($this->val, 0, count($this->val()) - $n);

    $this->val = $result;
  }

  public function dropLastWhile($predicate)
  {
    $endIndex = -1;
    $length = count($this->val);

    for ($i = $length - 1; $i >= 0; $i--) {
      $element = $this->val[$i];
      if ($predicate($element)) $endIndex = $i;
      else break;
    }

    $result = array_slice($this->val, 0, $endIndex);

    $this->val = $result;
  }

  public function dropRepeats()
  {
    $result = [$this->val[0]];
    $length = count($this->val);

    for ($i = 1; $i < $length; $i++) {
      $currentValue = $this->val[$i];
      $previousValue = $result[count($result) - 1];
      if ($currentValue !== $previousValue) $result[] = $this->val[$i];
    }

    $this->val = $result;
  }

  public function dropRepeatsBy($predicate)
  {
    $result = [$this->val[0]];

    for ($i = 1; $i < count($this->val); $i++) {
      $currentValue = $this->val[$i];
      $previousValue = $result[count($result) - 1];

      $valid = $predicate($currentValue, $previousValue);
      if ($valid) $result[] = $this->val[$i];
    }

    $this->val = $result;
  }

  public function endsWith($sublist)
  {
    $currentLength = count($this->val);
    $sublistLength = count($sublist);

    $valueToCheck = array_slice($this->val, $currentLength - $sublistLength);

    return $valueToCheck === $sublist;
  }

  public function filter($predicate)
  {
    $result = [];

    foreach ($this->val as $value) {
      $eligible = $predicate($value);
      if ($eligible) $result[] = $value;
    }

    $this->val = $result;
  }

  public function filterIndexed($predicate)
  {
    $result = [];

    foreach ($this->val as $index => $value) {
      $eligible = $predicate($index, $value);
      if ($eligible) $result[] = $value;
    }

    $this->val = $result;
  }

  public function filterNot($predicate)
  {
    $result = [];

    foreach ($this->val as $value) {
      $eligible = !$predicate($value);
      if ($eligible) $result[] = $value;
    }

    $this->val = $result;
  }

  public function filterNotIndexed($predicate)
  {
    $result = [];

    foreach ($this->val as $index => $value) {
      $eligible = !$predicate($index, $value);
      if ($eligible) $result[] = $value;
    }

    $this->val = $result;
  }

  public function find($predicate)
  {
    foreach ($this->val as $value) {
      if ($predicate($value)) return $value;
    }

    return null;
  }

  public function findLast($predicate)
  {
    for ($i = count($this->val) - 1; $i >= 0; $i++) {
      $value = $this->val[$i];
      if ($predicate($value)) return $value;
    }

    return null;
  }

  public function first()
  {
    $length = count($this->val);
    if ($length === 0) throw new Exception('The array is empty.');

    return $this->val[0];
  }

  public function firstOrNull()
  {
    $length = count($this->val);
    if ($length === 0) return null;

    return $this->val[0];
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

  public function flatten()
  {
    $result = $this->recurseFlatten($this->val);

    $this->val = $result;
  }

  public function forEach($action)
  {
    foreach ($this->val as $value) $action($value);
  }

  public function forEachIndexed($action)
  {
    foreach ($this->val as $key => $value) $action($key, $value);
  }

  public function fold($initial, $operation)
  {
    $accumulator = $initial;

    foreach ($this->val as $value) {
      $accumulator = $operation($accumulator, $value);
    }

    return $accumulator;
  }

  public function foldIndexed($initial, $operation)
  {
    $accumulator = $initial;

    foreach ($this->val as $index => $value) {
      $accumulator = $operation($accumulator, $index, $value);
    }

    return $accumulator;
  }

  public function foldRight($initial, $operation)
  {
    $accumulator = $initial;
    $lastIndex = count($this->val) - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $this->val[$i]);
    }

    return $accumulator;
  }

  public function foldRightIndexed($initial, $operation)
  {
    $accumulator = $initial;
    $lastIndex = count($this->val) - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $i, $this->val[$i]);
    }

    return $accumulator;
  }

  public function get($index)
  {
    return $this->val[$index];
  }

  public function getOrNull($index)
  {
    return $this->val[$index] ?? null;
  }

  public function getOrElse($index, $default)
  {
    return $this->val[$index] ?? $default;
  }

  private function pathGetter($path, $onNotFound)
  {
    if (gettype($path) === 'string') $path = explode('.', $path);

    $value = $this->val;

    foreach ($path as $key) {
      $exists = array_key_exists($key, $value);

      if (!$exists) return $onNotFound();
      $value = $value[$key];
    }

    return $value;
  }

  public function getOnPath($path)
  {
    $onNotFound = function () {
      throw new Exception('Path not found.');
    };

    return $this->pathGetter($path, $onNotFound);
  }

  public function getOnPathOrNull($path)
  {
    $onNotFound = function () {
      return null;
    };

    return $this->pathGetter($path, $onNotFound);
  }

  public function getOnPathOrElse($path, $default)
  {
    $onNotFound = function () use ($default) {
      return $default;
    };

    return $this->pathGetter($path, $onNotFound);
  }

  public function getOnPaths($paths)
  {
    $result = [];
    foreach ($paths as $path) {
      $result[] = $this->getOnPathOrNull($path);
    }

    return $result;
  }

  // Check
  public function getAsList($index)
  {
    return $this->val = $this->val[$index];
  }

  // Check
  public function getOnPathAsList($path)
  {
    return $this->val = $this->getOnPath($path);
  }

  public function groupBy($groupKeySelector, $valueTransform = null)
  {
    $result = [];

    foreach ($this->val as $value) {
      if ($valueTransform !== null) $value = $valueTransform($value);

      $groupKey = $groupKeySelector($value);

      if (isset($result[$groupKey])) $result[$groupKey][] = $value;
      else $result[$groupKey] = [$value];
    }

    $this->val = $result;
  }

  public function groupByKeyed($groupKeySelector, $keyTransform, $valueTransform)
  {
    $result = [];

    foreach ($this->val as $value) {
      if ($valueTransform !== null) $value = $valueTransform($value);

      $groupKey = $groupKeySelector($value);
      $key = $keyTransform($value);

      if (isset($result[$groupKey])) $result[$groupKey][$key] = $value;
      else $result[$groupKey] = [$key => $value];
    }

    $this->val = $result;
  }

  public function head()
  {
    return $this->val[0];
  }

  public function indexOf($element)
  {
    foreach ($this->val as $index => $value) {
      if ($value === $element) return $index;
    }

    return -1;
  }

  public function indexOfFirst($predicate)
  {
    foreach ($this->val as $index => $value) {
      if ($predicate($value)) return $index;
    }

    return -1;
  }

  public function indexOfLast($predicate)
  {
    $lastIndex = count($this->val) - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      if ($predicate($this->val[$i])) return $i;
    }

    return -1;
  }

  public function last()
  {
    return $this->val[count($this->val) - 1];
  }

  public function lastIndexOf($element)
  {
    $lastIndex = count($this->val) - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      if ($element === $this->val[$i]) return $i;
    }

    return -1;
  }

  public function map($transform)
  {
    $result = [];

    foreach ($this->val as $key => $value) {
      $result[] = $transform($value, $key);
    }

    $this->val = $result;
  }

  public function mapIndexed($transform)
  {
    $result = [];

    foreach ($this->val as $index => $value) {
      $result[] = $transform($index, $value);
    }

    $this->val = $result;
  }

  public function mapIndexedNotNull($transform)
  {
    $result = [];

    foreach ($this->val as $index => $value) {
      $resultValue  = $transform($index, $value);
      if ($resultValue !== null) $result[] = $resultValue;
    }

    $this->val = $result;
  }

  public function mapNotNull($transform)
  {
    $result = [];

    foreach ($this->val as $value) {
      $resultvalue = $transform($value);
      if ($resultvalue !== null) $result[] = $resultvalue;
    }

    $this->val = $result;
  }

  public function max()
  {
    return max($this->val);
  }

  // TODO
  public function median()
  {
  }

  public function min()
  {
    return min($this->val);
  }

  public function none($predicate)
  {
    foreach ($this->val as $item) {
      if ($predicate($item)) return false;
    }

    return true;
  }

  public function onEach($action)
  {
    foreach ($this->val as $value) {
      $action($value);
    }

    return $this;
  }

  public function onEachIndexed($action)
  {
    foreach ($this->val as $key => $value) {
      $action($key, $value);
    }

    return $this;
  }

  public function pluck($path, $default = null)
  {
    if (gettype($path) === 'string') $keys = explode('.', $path);

    $result = array_map(function ($value) use ($keys, $default) {
      $ref = $value;

      foreach ($keys as $key) {
        if (array_key_exists($key, $ref)) $ref = $ref[$key];
        else return $default;
      }

      return $ref;
    }, $this->val);

    $this->val = $result;
  }

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

  public function prepend($value)
  {
  }

  public function prependAll($list)
  {
  }

  public function reduce($operation)
  {
  }

  public function reduceIndexed($operation)
  {
  }

  public function reduceRight($operation)
  {
  }

  public function reduceRightIndexed($operation)
  {
  }

  public function reverse()
  {
  }

  public function runningFold($initial, $operation)
  {
  }

  public function runningFoldIndexed($initial, $operation)
  {
  }

  public function runningFoldRight($initial, $operation)
  {
  }

  public function runningFoldIndexedRight($initial, $operation)
  {
  }

  public function runningReduce($operation)
  {
  }

  public function runningReduceIndexed($operation)
  {
  }

  public function runningReduceRight($operation)
  {
  }

  public function runningReduceIndexedRight($operation)
  {
  }

  public function sum()
  {
  }

  public function startsWith($sublist)
  {
    $sublistLength = count($sublist);

    $valueToCheck = array_slice($this->val, 0, $sublistLength);

    return $valueToCheck === $sublist;
  }

  public function slice($from, $to)
  {
  }

  public function sortBy($comparator)
  {
  }

  public function splitAt()
  {
  }

  public function splitEvery($length)
  {
  }

  public function take($n)
  {
  }

  public function takeWhile($predicate)
  {
  }

  public function takeLast($n)
  {
  }

  public function takeLastWhile($predicate)
  {
  }

  public function tail()
  {
  }

  public function unzip()
  {
  }

  public function val()
  {
    return $this->val;
  }

  public function zip($other, $transform = null)
  {
  }
}
