<?php

namespace NoxImperium\Box\Types\ListType;

use Exception;

class ListType
{
  private $val;

  public function __construct($val)
  {
    $this->val = $val;
  }

  public static function repeat($value, $n)
  {
    $result = [];

    for ($i = 0; $i < $n; $i++) {
      $result[] = $value;
    }

    return new ListType($result);
  }

  public function all($predicate)
  {
    foreach ($this->val as $value) {
      if (!$predicate($value)) return false;
    }

    return true;
  }

  public function any($predicate)
  {
    foreach ($this->val as $value) {
      if ($predicate($value)) return true;
    }

    return false;
  }

  public function adjust($index, $transform)
  {
    $this->val[$index] = $transform($this->val[$index]);

    return new ListType($this->val);
  }

  public function append($value)
  {
    $this->val[] = $value;

    return new ListType($this->val);
  }

  public function appendAll($other)
  {
    array_push($this->val, ...$other);

    return new ListType($this->val);
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

    return array_values($result);
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

    return new ListType($result);
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

    return new ListType($result);
  }

  public function drop($n)
  {
    $result = array_slice($this->val, $n);

    return new ListType($result);
  }

  public function dropWhile($predicate)
  {
    $startIndex = 0;
    $length = count($this->val);

    for ($i = 0; $i < $length; $i++) {
      if (!$predicate($this->val[$i])) {
        $startIndex = $i;
        break;
      }
    }

    $result = array_slice($this->val, $startIndex);

    return new ListType($result);
  }

  public function dropLast($n)
  {
    $result = array_slice($this->val, 0, count($this->val) - $n);

    return new ListType($result);
  }

  public function dropLastWhile($predicate)
  {
    $length = count($this->val);
    $endIndex = $length;

    for ($i = $length - 1; $i >= 0; $i--) {
      if (!$predicate($this->val[$i])) {
        $endIndex = $i;
        break;
      }
    }

    $result = array_slice($this->val, 0, $endIndex);

    return new ListType($result);
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

    return new ListType($result);
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

    return new ListType($result);
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

    return new ListType($result);
  }

  public function filterIndexed($predicate)
  {
    $result = [];

    foreach ($this->val as $index => $value) {
      $eligible = $predicate($index, $value);
      if ($eligible) $result[] = $value;
    }

    return new ListType($result);
  }

  public function filterNot($predicate)
  {
    $result = [];

    foreach ($this->val as $value) {
      $eligible = !$predicate($value);
      if ($eligible) $result[] = $value;
    }

    return new ListType($result);
  }

  public function filterNotIndexed($predicate)
  {
    $result = [];

    foreach ($this->val as $index => $value) {
      $eligible = !$predicate($index, $value);
      if ($eligible) $result[] = $value;
    }

    return new ListType($result);
  }

  public function filterNotNull()
  {
    $result = [];

    foreach ($this->val as $value) {
      if ($value !== null) $result[] = $value;
    }

    return new ListType($result);
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
    $lastIndex = count($this->val) - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      if ($predicate($this->val[$i])) return $this->val[$i];
    }

    return -1;
  }

  public function findIndex($element)
  {
    foreach ($this->val as $index => $value) {
      if ($value === $element) return $index;
    }

    return -1;
  }

  public function findLastIndex($element)
  {
    $lastIndex = count($this->val) - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      if ($element === $this->val[$i]) return $i;
    }

    return -1;
  }

  public function first()
  {
    $length = count($this->val);
    if ($length === 0) throw new Exception('The List is empty.');

    return $this->val[0];
  }

  public function firstOrNull()
  {
    $length = count($this->val);
    if ($length === 0) return null;

    return $this->val[0];
  }

  public function flatMap($transform)
  {
    $result = [];
    foreach ($this->val as $value) {
      $result = array_merge($result, $transform($value));
    }

    return new ListType($result);
  }

  public function flatMapIndexed($transform)
  {
    $result = [];
    foreach ($this->val as $key => $value) {
      $result = array_merge($result, $transform($key, $value));
    }

    return new ListType($result);
  }

  public function flatten()
  {
    $result = [];
    foreach ($this->val as $value) {
      if (is_array($value)) $result = [...$result, ...$value];
      else $result[] = $value;
    }

    return new ListType($result);
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

  public function forEach($action)
  {
    foreach ($this->val as $value) {
      $action($value);
    }
  }

  public function forEachIndexed($action)
  {
    foreach ($this->val as $index => $value) {
      $action($index, $value);
    }
  }

  public function get($index)
  {
    return $this->val[$index];
  }

  public function getOrElse($index, $default)
  {
    return $this->val[$index] ?? $default;
  }

  public function getOrNull($index)
  {
    return $this->val[$index] ?? null;
  }

  public function getOnPath($path)
  {
    $onNotFound = function () {
      throw new Exception('Path not found.');
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

  public function getOnPathOrNull($path)
  {
    $onNotFound = function () {
      return null;
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

  public function groupBy($groupKeySelector, $valueTransform = null)
  {
    $result = [];

    foreach ($this->val as $value) {
      if ($valueTransform !== null) $value = $valueTransform($value);

      $groupKey = $groupKeySelector($value);

      if (isset($result[$groupKey])) $result[$groupKey][] = $value;
      else $result[$groupKey] = [$value];
    }

    return new ListType($result);
  }

  public function groupByKeyed($groupKeySelector, $keyTransform, $valueTransform = null)
  {
    $result = [];

    foreach ($this->val as $value) {
      if ($valueTransform !== null) $value = $valueTransform($value);

      $groupKey = $groupKeySelector($value);
      $key = $keyTransform($value);

      if (isset($result[$groupKey])) $result[$groupKey][$key] = $value;
      else $result[$groupKey] = [$key => $value];
    }

    return new ListType($result);
  }

  public function head()
  {
    return $this->val[0];
  }


  public function insert($index, $value)
  {
    $a = array_slice($this->val, 0, $index);
    $b = array_slice($this->val, $index);

    return new ListType([...$a, $value, ...$b]);
  }

  public function insertAll($index, $values)
  {
    if (gettype($values) !== 'array') $values = [$values];

    $a = array_slice($this->val, 0, $index);
    $b = array_slice($this->val, $index);

    return new ListType([...$a, ...$values, ...$b]);
  }

  public function last()
  {
    return $this->val[count($this->val) - 1];
  }

  public function map($transform)
  {
    $result = [];

    foreach ($this->val as $key => $value) {
      $result[] = $transform($value, $key);
    }

    return new ListType($result);
  }

  public function mapNotNull($transform)
  {
    $result = [];

    foreach ($this->val as $value) {
      $resultvalue = $transform($value);
      if ($resultvalue !== null) $result[] = $resultvalue;
    }

    return new ListType($result);
  }

  public function mapIndexed($transform)
  {
    $result = [];

    foreach ($this->val as $index => $value) {
      $result[] = $transform($index, $value);
    }

    return new ListType($result);
  }

  public function mapIndexedNotNull($transform)
  {
    $result = [];

    foreach ($this->val as $index => $value) {
      $resultValue  = $transform($index, $value);
      if ($resultValue !== null) $result[] = $resultValue;
    }

    return new ListType($result);
  }

  public function max()
  {
    return max($this->val);
  }

  public function min()
  {
    return min($this->val);
  }

  public function move($from, $to)
  {
    $a = $this->val[$from];
    $b = $this->val[$to];

    $this->val[$from] = $b;
    $this->val[$to] = $a;

    return new ListType($this->val);
  }

  public function none($predicate)
  {
    foreach ($this->val as $value) {
      if ($predicate($value)) return false;
    }

    return true;
  }

  public function onEach($action)
  {
    $this->forEach($action);

    return $this;
  }

  public function onEachIndexed($action)
  {
    $this->forEachIndexed($action);

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

    return new ListType($result);
  }

  public function partition($predicate)
  {
    $satisfy = [];
    $dissatisfy = [];

    foreach ($this->val as $value) {
      if ($predicate($value)) $satisfy[] = $value;
      else $dissatisfy[] = $value;
    }

    return new ListType([$satisfy, $dissatisfy]);
  }

  public function prepend($value)
  {
    $result = [$value, ...$this->val];

    return new ListType($result);
  }

  public function prependAll($other)
  {
    $result = [...$other, ...$this->val];

    return new ListType($result);
  }

  public function reduce($operation)
  {
    $length = count($this->val);
    if ($length === 0) throw new Exception('List is empty.');

    $accumulator = $this->val[0];

    for ($i = 1; $i < $length; $i++) {
      $accumulator = $operation($accumulator, $this->val[$i]);
    }

    return $accumulator;
  }

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

  public function reduceIndexed($operation)
  {
    $length = count($this->val);
    if ($length === 0) throw new Exception('List is empty.');

    $accumulator = $this->val[0];

    for ($i = 1; $i < $length; $i++) {
      $accumulator = $operation($accumulator, $i, $this->val[$i]);
    }

    return $accumulator;
  }

  public function reduceIndexedOrNull($operation)
  {
    $length = count($this->val);
    if ($length === 0) return null;

    $accumulator = $this->val[0];

    for ($i = 1; $i < $length; $i++) {
      $accumulator = $operation($accumulator, $i, $this->val[$i]);
    }

    return $accumulator;
  }


  public function reduceRight($operation)
  {
    $length = count($this->val);
    if ($length === 0) throw new Exception('List is empty.');

    $accumulator = $this->val[$length - 1];
    $lastIndex = $length - 2;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $this->val[$i]);
    }

    return $accumulator;
  }

  public function reduceRightOrNull($operation)
  {
    $length = count($this->val);
    if ($length === 0) return null;

    $accumulator = $this->val[$length - 1];
    $lastIndex = $length - 2;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $this->val[$i]);
    }

    return $accumulator;
  }

  public function reduceRightIndexed($operation)
  {
    $length = count($this->val);
    if ($length === 0) throw new Exception('List is empty.');

    $accumulator = $this->val[0];
    $lastIndex = $length - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $i, $this->val[$i]);
    }

    return $accumulator;
  }

  public function reduceRightIndexedOrNull($operation)
  {
    $length = count($this->val);
    if ($length === 0) return null;

    $accumulator = $this->val[0];
    $lastIndex = $length - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $i, $this->val[$i]);
    }

    return $accumulator;
  }

  public function removeFirst()
  {
    array_shift($this->val);

    return new ListType($this->val);
  }

  public function removeLast()
  {
    array_pop($this->val);

    return new ListType($this->val);
  }

  public function replace($index, $value)
  {
    $this->val[$index] = $value;

    return new ListType($this->val);
  }

  public function reverse()
  {
    return new ListType(array_reverse($this->val));
  }

  public function runningFold($initial, $operation)
  {
    $accumulator = $initial;
    $result = [$accumulator];

    foreach ($this->val as $value) {
      $accumulator = $operation($accumulator, $value);
      $result[] = $accumulator;
    }

    return new ListType($result);
  }

  public function runningFoldIndexed($initial, $operation)
  {
    $accumulator = $initial;
    $result = [$accumulator];

    foreach ($this->val as $index => $value) {
      $accumulator = $operation($accumulator, $index, $value);
      $result[] = $accumulator;
    }

    return new ListType($result);
  }

  public function runningFoldRight($initial, $operation)
  {
    $accumulator = $initial;
    $result = [$accumulator];
    $lastIndex = count($this->val) - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $this->val[$i]);
      $result[] = $accumulator;
    }

    return new ListType($result);
  }

  public function runningFoldRightIndexed($initial, $operation)
  {
    $accumulator = $initial;
    $result = [$accumulator];
    $lastIndex = count($this->val) - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $i, $this->val[$i]);
      $result[] = $accumulator;
    }

    return new ListType($result);
  }

  public function runningReduce($operation)
  {
    $length = count($this->val);
    $accumulator = $this->val[0];
    $result = [$accumulator];

    for ($i = 1; $i < $length; $i++) {
      $accumulator = $operation($accumulator, $this->val[$i]);
      $result[] = $accumulator;
    }

    return new ListType($result);
  }

  public function runningReduceIndexed($operation)
  {
    $length = count($this->val);
    $accumulator = $this->val[0];
    $result = [$accumulator];

    for ($i = 1; $i < $length; $i++) {
      $accumulator = $operation($accumulator, $i, $this->val[$i]);
      $result[] = $accumulator;
    }

    return new ListType($result);
  }

  public function runningReduceRight($operation)
  {
    $length = count($this->val);
    $lastIndex = $length - 2;
    $accumulator = $this->val[$length - 1];
    $result = [$accumulator];

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $this->val[$i]);
      $result[] = $accumulator;
    }

    return new ListType($result);
  }

  public function runningReduceRightIndexed($operation)
  {
    $length = count($this->val);
    $lastIndex = $length - 2;
    $accumulator = $this->val[$length - 1];
    $result = [$accumulator];

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $i, $this->val[$i]);
      $result[] = $accumulator;
    }

    return new ListType($result);
  }

  public function size()
  {
    return count($this->val);
  }

  public function sum()
  {
    return array_sum($this->val);
  }

  public function startsWith($sublist)
  {
    $sublistLength = count($sublist);
    $valueToCheck = array_slice($this->val, 0, $sublistLength);

    return $valueToCheck === $sublist;
  }

  public function slice($from, $to)
  {
    return new ListType(array_slice($this->val, $from, $to - $from));
  }

  public function sortBy($selector)
  {
    $result = $this->val;
    usort($result, function ($a, $b) use ($selector) {
      return $selector($a) - $selector($b);
    });

    return new ListType($result);
  }

  public function sortByDescending($selector)
  {
    $result = $this->val;
    usort($result, function ($a, $b) use ($selector) {
      return $selector($b) - $selector($a);
    });

    return new ListType($result);
  }

  public function splitAt($index)
  {
    $a = array_slice($this->val, 0, $index);
    $b = array_slice($this->val, $index);

    return new ListType([$a, $b]);
  }

  public function splitEvery($length)
  {
    $chunked = [];
    $temp = [];

    foreach ($this->val as $value) {
      $temp[] = $value;
      if (count($temp) === $length) {
        $chunked[] = $temp;
        $temp = [];
      }
    }

    if (count($temp) !== 0) $chunked[] = $temp;

    return new ListType($chunked);
  }

  public function take($n)
  {
    $result = array_slice($this->val, 0, $n);

    return new ListType($result);
  }

  public function takeWhile($predicate)
  {
    $result = [];
    $length = count($this->val);

    for ($i = 0; $i < $length; $i++) {
      if ($predicate($this->val[$i])) $result[] = $this->val[$i];
      else break;
    }

    return new ListType($result);
  }

  public function takeLast($n)
  {
    $result = array_slice($this->val, count($this->val) - $n);

    return new ListType($result);
  }

  public function takeLastWhile($predicate)
  {
    $length = count($this->val);
    $startIndex = 0;

    for ($i = $length - 1; $i >= 0; $i--) {
      if (!$predicate($this->val[$i])) {
        $startIndex = $i + 1;
        break;
      }
    }

    $result = array_slice($this->val, $startIndex);

    return new ListType($result);
  }

  public function tail()
  {
    return new ListType(array_slice($this->val, 1));
  }

  public function unzip()
  {
    $a = [];
    $b = [];

    foreach ($this->val as $element) {
      $a[] = $element[0];
      $b[] = $element[1];
    }

    return new ListType([$a, $b]);
  }

  public function val()
  {
    return $this->val;
  }

  public function zip($other)
  {
    $listLength = count($this->val);
    $otherLength = count($other);

    $resultLength = $listLength <= $otherLength ? $listLength : $otherLength;

    $result = [];
    for ($i = 0; $i < $resultLength; $i++) {
      $result[] = [$this->val[$i], $other[$i]];
    }

    return new ListType($result);
  }

  public function zipWith($other, $transform)
  {
    $listLength = count($this->val);
    $otherLength = count($other);

    $resultLength = $listLength <= $otherLength ? $listLength : $otherLength;

    $result = [];
    for ($i = 0; $i < $resultLength; $i++) {
      $result[] = $transform($this->val[$i], $other[$i]);
    }

    return new ListType($result);
  }

  private function pathGetter($path, $onNotFound, $list)
  {
    if (gettype($path) === 'string') $path = explode('.', $path);

    $value = $list;

    foreach ($path as $key) {
      $exists = array_key_exists($key, $value);

      if (!$exists) return $onNotFound();
      $value = $value[$key];
    }

    return $value;
  }
}
