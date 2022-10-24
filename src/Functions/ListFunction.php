<?php

namespace NoxImperium\Box\Functions;

/**
 * PLAN
 * Add Methods:
 * Intersperse
 * Move
 * Replace
 * 
 * Add Static Function:
 * Range
 * Repeat
 */

use Exception;

class ListFunction
{
  public function all($predicate, $list)
  {
    foreach ($list as $value) {
      if (!$predicate($value)) return false;
    }

    return true;
  }

  public function any($predicate, $list)
  {
    foreach ($list as $value) {
      if ($predicate($value)) return true;
    }

    return false;
  }

  public function adjust($index, $transform, $list)
  {
    $list[$index] = $transform($list[$index]);
    return $list;
  }

  public function append($value, $list)
  {
    $list[] = $value;

    return $list;
  }

  public function appendAll($other, $list)
  {
    array_push($list, ...$other);

    return $list;
  }

  public function average($list)
  {
    return array_sum($list) / count($list);
  }

  public function contains($element, $list)
  {
    foreach ($list as $value) {
      if ($element === $value) return true;
    }

    return false;
  }

  public function containsAll($values, $list)
  {
    foreach ($values as $value) {
      if (!in_array($value, $list)) return false;
    }

    return true;
  }

  public function collectBy($keySelector, $list)
  {
    $result = [];

    foreach ($list as $value) {
      $key = $keySelector($value);
      if (isset($result[$key])) $result[$key][] = $value;
      else $result[$key] = [$value];
    }

    return array_values($result);
  }

  public function count($predicate, $list)
  {
    $count = 0;
    foreach ($list as $value) {
      if ($predicate($value)) $count++;
    }

    return $count;
  }

  public function distinct($list)
  {
    $result = [];
    foreach ($list as $value) {
      if (!in_array($value, $result)) $result[] = $value;
    }

    return $result;
  }

  public function distinctBy($keySelector, $list)
  {
    $result = [];
    $determiners = [];

    foreach ($list as $value) {
      $determiner = $keySelector($value);

      if (!in_array($determiner, $determiners)) {
        $determiners[] = $determiner;
        $result[] = $value;
      }
    }

    return $result;
  }

  public function drop($n, $list)
  {
    $result = array_slice($list, $n);

    return $result;
  }

  public function dropWhile($predicate, $list)
  {
    $startIndex = 0;
    $length = count($list);

    for ($i = 0; $i < $length; $i++) {
      if (!$predicate($list[$i])) {
        $startIndex = $i;
        break;
      }
    }

    $result = array_slice($list, $startIndex);

    return $result;
  }

  public function dropLast($n, $list)
  {
    $result = array_slice($list, 0, count($list) - $n);

    return $result;
  }

  public function dropLastWhile($predicate, $list)
  {
    $length = count($list);
    $endIndex = $length;

    for ($i = $length - 1; $i >= 0; $i--) {
      if (!$predicate($list[$i])) {
        $endIndex = $i;
        break;
      }
    }

    $result = array_slice($list, 0, $endIndex);

    return $result;
  }

  public function dropRepeats($list)
  {
    $result = [$list[0]];
    $length = count($list);

    for ($i = 1; $i < $length; $i++) {
      $currentValue = $list[$i];
      $previousValue = $result[count($result) - 1];
      if ($currentValue !== $previousValue) $result[] = $list[$i];
    }

    return $result;
  }

  public function dropRepeatsBy($predicate, $list)
  {
    $result = [$list[0]];

    for ($i = 1; $i < count($list); $i++) {
      $currentValue = $list[$i];
      $previousValue = $result[count($result) - 1];

      $valid = $predicate($currentValue, $previousValue);
      if ($valid) $result[] = $list[$i];
    }

    return $result;
  }

  public function endsWith($sublist, $list)
  {
    $currentLength = count($list);
    $sublistLength = count($sublist);

    $valueToCheck = array_slice($list, $currentLength - $sublistLength);

    return $valueToCheck === $sublist;
  }

  public function filter($predicate, $list)
  {
    $result = [];

    foreach ($list as $value) {
      $eligible = $predicate($value);
      if ($eligible) $result[] = $value;
    }

    return $result;
  }

  public function filterIndexed($predicate, $list)
  {
    $result = [];

    foreach ($list as $index => $value) {
      $eligible = $predicate($index, $value);
      if ($eligible) $result[] = $value;
    }

    return $result;
  }

  public function filterNot($predicate, $list)
  {
    $result = [];

    foreach ($list as $value) {
      $eligible = !$predicate($value);
      if ($eligible) $result[] = $value;
    }

    return $result;
  }

  public function filterNotIndexed($predicate, $list)
  {
    $result = [];

    foreach ($list as $index => $value) {
      $eligible = !$predicate($index, $value);
      if ($eligible) $result[] = $value;
    }

    return $result;
  }

  public function filterNotNull($list)
  {
    $result = [];

    foreach ($list as $value) {
      if ($value !== null) $result[] = $value;
    }

    return $result;
  }

  public function find($predicate, $list)
  {
    foreach ($list as $value) {
      if ($predicate($value)) return $value;
    }

    return null;
  }

  public function findLast($predicate, $list)
  {
    $lastIndex = count($list) - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      if ($predicate($list[$i])) return $list[$i];
    }

    return -1;
  }

  public function findIndex($element, $list)
  {
    foreach ($list as $index => $value) {
      if ($value === $element) return $index;
    }

    return -1;
  }

  public function findLastIndex($element, $list)
  {
    $lastIndex = count($list) - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      if ($element === $list[$i]) return $i;
    }

    return -1;
  }

  public function first($list)
  {
    $length = count($list);
    if ($length === 0) throw new Exception('The List is empty.');

    return $list[0];
  }

  public function firstOrNull($list)
  {
    $length = count($list);
    if ($length === 0) return null;

    return $list[0];
  }

  public function flatMap($transform, $list)
  {
    $result = [];
    foreach ($list as $value) {
      $result = array_merge($result, $transform($value));
    }

    return $result;
  }

  public function flatMapIndexed($transform, $list)
  {
    $result = [];
    foreach ($list as $key => $value) {
      $result = array_merge($result, $transform($key, $value));
    }

    return $result;
  }

  private function recurseFlatten($value)
  {
    $result = [];

    foreach ($value as $value) {
      if (gettype($value) !== 'array') $result[] = $value;
      else $result = array_merge($result, $this->recurseFlatten($value));
    }

    return $result;
  }

  public function flatten($list)
  {
    $result = $this->recurseFlatten($list);

    return $result;
  }

  public function fold($initial, $operation, $list)
  {
    $accumulator = $initial;

    foreach ($list as $value) {
      $accumulator = $operation($accumulator, $value);
    }

    return $accumulator;
  }

  public function foldIndexed($initial, $operation, $list)
  {
    $accumulator = $initial;

    foreach ($list as $index => $value) {
      $accumulator = $operation($accumulator, $index, $value);
    }

    return $accumulator;
  }

  public function foldRight($initial, $operation, $list)
  {
    $accumulator = $initial;
    $lastIndex = count($list) - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $list[$i]);
    }

    return $accumulator;
  }

  public function foldRightIndexed($initial, $operation, $list)
  {
    $accumulator = $initial;
    $lastIndex = count($list) - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $i, $list[$i]);
    }

    return $accumulator;
  }

  public function forEach($action, $list)
  {
    foreach ($list as $value) {
      $action($value);
    }
  }

  public function forEachIndexed($action, $list)
  {
    foreach ($list as $key => $value) {
      $action($key, $value);
    }
  }

  public function get($index, $list)
  {
    return $list[$index];
  }

  public function getOrElse($index, $default, $list)
  {
    return $list[$index] ?? $default;
  }

  public function getOrNull($index, $list)
  {
    return $list[$index] ?? null;
  }

  public function getOnPath($path, $list)
  {
    $onNotFound = function () {
      throw new Exception('Path not found.');
    };

    return $this->pathGetter($path, $onNotFound, $list);
  }

  public function getOnPathOrElse($path, $default, $list)
  {
    $onNotFound = function () use ($default) {
      return $default;
    };

    return $this->pathGetter($path, $onNotFound, $list);
  }

  public function getOnPathOrNull($path, $list)
  {
    $onNotFound = function () {
      return null;
    };

    return $this->pathGetter($path, $onNotFound, $list);
  }

  public function getOnPaths($paths, $list)
  {
    $result = [];
    foreach ($paths as $path) {
      $result[] = $this->getOnPathOrNull($path, $list);
    }

    return $result;
  }

  public function groupBy($groupKeySelector, $valueTransform = null, $list)
  {
    $result = [];

    foreach ($list as $value) {
      if ($valueTransform !== null) $value = $valueTransform($value);

      $groupKey = $groupKeySelector($value);

      if (isset($result[$groupKey])) $result[$groupKey][] = $value;
      else $result[$groupKey] = [$value];
    }

    return $result;
  }

  public function groupByKeyed($groupKeySelector, $keyTransform, $valueTransform, $list)
  {
    $result = [];

    foreach ($list as $value) {
      if ($valueTransform !== null) $value = $valueTransform($value);

      $groupKey = $groupKeySelector($value);
      $key = $keyTransform($value);

      if (isset($result[$groupKey])) $result[$groupKey][$key] = $value;
      else $result[$groupKey] = [$key => $value];
    }

    return $result;
  }

  public function head($list)
  {
    return $list[0];
  }

  public function insert($index, $value, $list)
  {
    $a = array_slice($list, 0, $index);
    $b = array_slice($list, $index);

    return [...$a, $value, ...$b];
  }

  public function insertAll($index, $values, $list)
  {
    if (gettype($values) !== 'array') $values = [$values];

    $a = array_slice($list, 0, $index);
    $b = array_slice($list, $index);

    return [...$a, ...$values, ...$b];
  }

  public function last($list)
  {
    return $list[count($list) - 1];
  }

  public function map($transform, $list)
  {
    $result = [];

    foreach ($list as $key => $value) {
      $result[] = $transform($value, $key);
    }

    return $result;
  }

  public function mapIndexed($transform, $list)
  {
    $result = [];

    foreach ($list as $index => $value) {
      $result[] = $transform($index, $value);
    }

    return $result;
  }

  public function mapNotNull($transform, $list)
  {
    $result = [];

    foreach ($list as $value) {
      $resultvalue = $transform($value);
      if ($resultvalue !== null) $result[] = $resultvalue;
    }

    return $result;
  }

  public function mapIndexedNotNull($transform, $list)
  {
    $result = [];

    foreach ($list as $index => $value) {
      $resultValue  = $transform($index, $value);
      if ($resultValue !== null) $result[] = $resultValue;
    }

    return $result;
  }

  public function max($list)
  {
    return max($list);
  }

  public function min($list)
  {
    return min($list);
  }

  public function move($from, $to, $list)
  {
    $a = $list[$from];
    $b = $list[$to];

    $list[$from] = $b;
    $list[$to] = $a;

    return $list;
  }

  public function none($predicate, $list)
  {
    foreach ($list as $value) {
      if ($predicate($value)) return false;
    }

    return true;
  }

  public function pluck($path, $default = null, $list)
  {
    if (gettype($path) === 'string') $keys = explode('.', $path);

    $result = array_map(function ($value) use ($keys, $default) {
      $ref = $value;

      foreach ($keys as $key) {
        if (array_key_exists($key, $ref)) $ref = $ref[$key];
        else return $default;
      }

      return $ref;
    }, $list);

    return $result;
  }

  public function partition($predicate, $list)
  {
    $satisfy = [];
    $dissatisfy = [];

    foreach ($list as $value) {
      if ($predicate($value)) $satisfy[] = $value;
      else $dissatisfy[] = $value;
    }

    return [$satisfy, $dissatisfy];
  }

  public function prepend($value, $list)
  {
    $result = [$value, ...$list];

    return $result;
  }

  public function prependAll($other, $list)
  {
    $result = [...$other, ...$list];

    return $result;
  }

  public function reduce($operation, $list)
  {
    $length = count($list);
    if ($length === 0) throw new Exception('List is empty.');

    $accumulator = $list[0];

    for ($i = 1; $i < $length; $i++) {
      $accumulator = $operation($accumulator, $list[$i]);
    }

    return $accumulator;
  }

  public function reduceOrNull($operation, $list)
  {
    $length = count($list);
    if ($length === 0) return null;

    $accumulator = $list[0];

    for ($i = 1; $i < $length; $i++) {
      $accumulator = $operation($accumulator, $list[$i]);
    }

    return $accumulator;
  }

  public function reduceIndexed($operation, $list)
  {
    $length = count($list);
    if ($length === 0) throw new Exception('List is empty.');

    $accumulator = $list[0];

    for ($i = 1; $i < $length; $i++) {
      $accumulator = $operation($i, $accumulator, $list[$i]);
    }

    return $accumulator;
  }

  public function reduceIndexedOrNull($operation, $list)
  {
    $length = count($list);
    if ($length === 0) return null;

    $accumulator = $list[0];

    for ($i = 1; $i < $length; $i++) {
      $accumulator = $operation($i, $accumulator, $list[$i]);
    }

    return $accumulator;
  }

  public function reduceRight($operation, $list)
  {
    $length = count($list);
    if ($length === 0) throw new Exception('List is empty.');

    $accumulator = $list[$length - 1];
    $lastIndex = $length - 2;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $list[$i]);
    }

    return $accumulator;
  }

  public function reduceRightOrNull($operation, $list)
  {
    $length = count($list);
    if ($length === 0) return null;

    $accumulator = $list[$length - 1];
    $lastIndex = $length - 2;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $list[$i]);
    }

    return $accumulator;
  }

  public function reduceRightIndexed($operation, $list)
  {
    $length = count($list);
    if ($length === 0) throw new Exception('List is empty.');

    $accumulator = $list[0];
    $lastIndex = $length - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($i, $accumulator, $list[$i]);
    }

    return $accumulator;
  }

  public function reduceRightIndexedOrNull($operation, $list)
  {
    $length = count($list);
    if ($length === 0) return null;

    $accumulator = $list[0];
    $lastIndex = $length - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($i, $accumulator, $list[$i]);
    }

    return $accumulator;
  }

  public function removeFirst($list)
  {
    array_shift($list);

    return $list;
  }

  public function removeLast($list)
  {
    array_pop($list);

    return $list;
  }


  public function reverse($list)
  {
    return array_reverse($list);
  }

  /**
   * Returns a list containing successive accumulation values generated by applying operation from left to right 
   * to each element and current accumulator value that starts with initial value.
   */
  public function runningFold($initial, $operation, $list)
  {
    $accumulator = $initial;
    $result = [$accumulator];

    foreach ($list as $value) {
      $accumulator = $operation($accumulator, $value);
      $result[] = $accumulator;
    }

    return $result;
  }

  /**
   * Returns a list containing successive accumulation values generated by applying operation from left to right 
   * to each element, its index in the original collection and current accumulator value that starts with initial value.
   */
  public function runningFoldIndexed($initial, $operation, $list)
  {
    $accumulator = $initial;
    $result = [$accumulator];

    foreach ($list as $index => $value) {
      $accumulator = $operation($accumulator, $index, $value);
      $result[] = $accumulator;
    }

    return $result;
  }

  public function runningFoldRight($initial, $operation, $list)
  {
    $accumulator = $initial;
    $result = [$accumulator];
    $lastIndex = count($list) - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $list[$i]);
      $result[] = $accumulator;
    }

    return $result;
  }

  public function runningFoldRightIndexed($initial, $operation, $list)
  {
    $accumulator = $initial;
    $result = [$accumulator];
    $lastIndex = count($list) - 1;

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $i, $list[$i]);
      $result[] = $accumulator;
    }

    return $result;
  }

  /**
   * Returns a list containing successive accumulation values generated by applying operation from left to right
   * to each element and current accumulator value that starts with the first element of this collection.
   */
  public function runningReduce($operation, $list)
  {
    $length = count($list);
    $accumulator = $list[0];
    $result = [$accumulator];

    for ($i = 1; $i < $length; $i++) {
      $accumulator = $operation($accumulator, $list[$i]);
      $result[] = $accumulator;
    }

    return $result;
  }

  /**
   * Returns a list containing successive accumulation values generated by applying operation from left to right
   * to each element, its index in the original collection and current accumulator value that starts with the first element of this collection.
   */
  public function runningReduceIndexed($operation, $list)
  {
    $length = count($list);
    $accumulator = $list[0];
    $result = [$accumulator];

    for ($i = 1; $i < $length; $i++) {
      $accumulator = $operation($accumulator, $i, $list[$i]);
      $result[] = $accumulator;
    }

    return $result;
  }

  public function runningReduceRight($operation, $list)
  {
    $length = count($list);
    $lastIndex = $length - 2;
    $accumulator = $list[$length - 1];
    $result = [$accumulator];

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $list[$i]);
      $result[] = $accumulator;
    }

    return $result;
  }

  public function runningReduceRightIndexed($operation, $list)
  {
    $length = count($list);
    $lastIndex = $length - 2;
    $accumulator = $list[$length - 1];
    $result = [$accumulator];

    for ($i = $lastIndex; $i >= 0; $i--) {
      $accumulator = $operation($accumulator, $i, $list[$i]);
      $result[] = $accumulator;
    }

    return $result;
  }

  public function sum($list)
  {
    return array_sum($list);
  }

  public function startsWith($sublist, $list)
  {
    $sublistLength = count($sublist);

    $valueToCheck = array_slice($list, 0, $sublistLength);

    return $valueToCheck === $sublist;
  }

  public function slice($from, $to, $list)
  {
    return array_slice($list, $from, $to - $from);
  }

  public function sortBy($selector, $list)
  {
    $result = $list;
    usort($result, function ($a, $b) use ($selector) {
      return $selector($a) - $selector($b);
    });

    return $result;
  }

  public function sortByDescending($selector, $list)
  {
    $result = $list;
    usort($result, function ($a, $b) use ($selector) {
      return $selector($b) - $selector($a);
    });

    return $result;
  }

  public function splitAt($index, $list)
  {
    $a = array_slice($list, 0, $index);
    $b = array_slice($list, $index);

    return [$a, $b];
  }

  public function splitEvery($length, $list)
  {
    $chunked = [];
    $temp = [];

    foreach ($list as $value) {
      $temp[] = $value;
      if (count($temp) === $length) {
        $chunked[] = $temp;
        $temp = [];
      }
    }

    if (count($temp) !== 0) $chunked[] = $temp;

    return $chunked;
  }

  /**
   * Returns a list containing first n elements.
   */
  public function take($n, $list)
  {
    $result = array_slice($list, 0, $n);

    return $result;
  }

  /**
   * Returns a list containing last n elements.
   */
  public function takeLast($n, $list)
  {
    $result = array_slice($list, count($list) - $n);

    return $result;
  }

  /**
   * Returns a list containing last elements satisfying the given predicate.
   */
  public function takeLastWhile($predicate, $list)
  {
    $length = count($list);
    $startIndex = 0;

    for ($i = $length - 1; $i >= 0; $i--) {
      if (!$predicate($list[$i])) {
        $startIndex = $i + 1;
        break;
      }
    }

    $result = array_slice($list, $startIndex);

    return $result;
  }

  /**
   * Returns a list containing first elements satisfying the given predicate.
   */
  public function takeWhile($predicate, $list)
  {
    $result = [];
    $length = count($list);

    for ($i = 0; $i < $length; $i++) {
      if ($predicate($list[$i])) $result[] = $list[$i];
      else break;
    }

    return $result;
  }

  public function tail($list)
  {
    return array_slice($list, 1);
  }

  public function unzip($list)
  {
    $a = [];
    $b = [];

    foreach ($list as $element) {
      $a[] = $element[0];
      $b[] = $element[1];
    }

    return [$a, $b];
  }

  public function where($key, $value, $list)
  {
    $result = [];

    foreach ($list as $pair) {
      if (isset($pair[$key]) && $pair[$key] === $value) $result[] = $pair;
    }

    return $result;
  }

  public function whereComparison($key, $operator, $value, $list)
  {
    $result = [];

    foreach ($list as $pair) {
      $isExists = isset($pair[$key]);
      $isEligible = $isExists ? $this->compare($operator, $pair[$key], $value) : false;
      if ($isExists && $isEligible) $result[] = $pair;
    }

    return $result;
  }

  public function whereBetween($key, $from, $to, $list)
  {
    $result = [];

    foreach ($list as $pair) {
      $isExists = isset($pair[$key]);
      $isEligible = $isExists ? ($pair[$key] >= $from && $pair[$key] <= $to) : false;
      if ($isExists && $isEligible) $result[] = $pair;
    }

    return $result;
  }

  public function whereNotBetween($key, $from, $to, $list)
  {
    $result = [];

    foreach ($list as $pair) {
      $isExists = isset($pair[$key]);
      $isEligible = $isExists ? !($pair[$key] >= $from && $pair[$key] <= $to) : false;
      if ($isExists && $isEligible) $result[] = $pair;
    }

    return $result;
  }

  public function whereIn($key, $values, $list)
  {
    $result = [];

    foreach ($list as $pair) {
      $isExists = isset($pair[$key]);
      $isEligible = $isExists ? in_array($pair[$key], $values, true) : false;
      if ($isExists && $isEligible) $result[] = $pair;
    }

    return $result;
  }

  public function whereNotIn($key, $values, $list)
  {
    $result = [];

    foreach ($list as $pair) {
      $isExists = isset($pair[$key]);
      $isEligible = $isExists ? !in_array($pair[$key], $values, true) : false;
      if ($isExists && $isEligible) $result[] = $pair;
    }

    return $result;
  }


  public function zip($other, $list)
  {
    $listLength = count($list);
    $otherLength = count($other);

    $resultLength = $listLength <= $otherLength ? $listLength : $otherLength;

    $result = [];
    for ($i = 0; $i < $resultLength; $i++) {
      $result[] = [$list[$i], $other[$i]];
    }

    return $result;
  }

  public function zipWith($other, $transform, $list)
  {
    $listLength = count($list);
    $otherLength = count($other);

    $resultLength = $listLength <= $otherLength ? $listLength : $otherLength;

    $result = [];
    for ($i = 0; $i < $resultLength; $i++) {
      $result[] = $transform($list[$i], $other[$i]);
    }

    return $result;
  }

  private function compare($operator, $a, $b)
  {
    if ($operator === '===') return $a === $b;
    if ($operator === '!==') return $a !== $b;

    if ($operator === '==') return $a == $b;
    if ($operator === '!=') return $a != $b;

    if ($operator === '>=') return $a >= $b;
    if ($operator === '<=') return $a <= $b;

    if ($operator === '>') return $a > $b;
    if ($operator === '<') return $a < $b;
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
