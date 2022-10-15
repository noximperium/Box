<?php

namespace NoxImperium\Container;

use Exception;
use NoxImperium\Container\Interfaces\BaseList;

class MutableList implements BaseList
{
  private array $val;

  private function __construct($val)
  {
    $this->val = $val;
  }

  /**
   * Returns an instance of ImmutableArray with passed initial value.
   */
  public static function from($val = [])
  {
    if (gettype($val) !== 'array') throw new Exception('Initial value must be an array');

    return new ImmutableList($val);
  }

  /**
   * Returns an instance of ImmutableArray with passed value.
   */
  public static function of(...$args)
  {
    return new ImmutableList(...$args);
  }

  /**
   * Returns a fixed list of size n containing a specified identical value.
   */
  public static function repeat($value, $n)
  {
    $result = [];

    for ($i = 0; $i < $n; $i++) {
      $result[] = $value;
    }

    return new ImmutableList($result);
  }

  public function all($predicate)
  {
  }

  public function any($predicate)
  {
  }

  public function append($value)
  {
  }

  public function appendAll($list)
  {
  }

  public function average($default = null)
  {
  }

  public function contains($value)
  {
  }

  public function containsAll($values)
  {
  }

  public function collectBy($selector)
  {
  }

  public function count($predicate)
  {
  }

  public function distinct()
  {
  }

  public function distinctBy($predicate)
  {
  }

  public function drop($n)
  {
  }

  public function dropWhile($predicate)
  {
  }

  public function dropLast($size)
  {
  }

  public function dropLastWhile($predicate)
  {
  }

  public function dropRepeats()
  {
  }

  public function dropRepeatsBy($predicate)
  {
  }

  public function endsWith($sublist)
  {
  }

  public function filter($bipredicate)
  {
  }

  public function filterNot($bipredicate)
  {
  }

  public function find($predicate)
  {
  }

  public function findLast($predicate)
  {
  }

  public function first()
  {
  }

  public function flatten()
  {
  }

  public function forEach($action)
  {
  }

  public function forEachIndexed($action)
  {
  }

  public function fold($initial, $operation)
  {
  }

  public function foldIndexed($initial, $operation)
  {
  }

  public function foldRight($initial, $operation)
  {
  }

  public function foldRightIndexed($initial, $operation)
  {
  }

  public function get($index)
  {
  }

  public function getOrNull($index)
  {
  }

  public function getOrElse($index, $default)
  {
  }

  public function getOnPath($path)
  {
  }

  public function getOnPathOrNull($path)
  {
  }

  public function getOnPathOrElse($path, $default)
  {
  }

  public function getOnPaths($paths)
  {
  }

  public function getAsList($index)
  {
  }

  public function getOnPathAsList($index)
  {
  }

  public function groupBy($groupKeySelector, $valueTransform)
  {
  }

  public function groupByKeyed($groupKeySelector, $keyTransform, $valueTransform)
  {
  }

  public function head()
  {
  }

  public function indexOf($element)
  {
  }

  public function indexOfFirst($predicate)
  {
  }

  public function indexOfLast($predicate)
  {
  }

  public function last()
  {
  }

  public function lastIndexOf($element)
  {
  }

  public function map($function)
  {
  }

  public function mapNotNull($function)
  {
  }

  public function mapIndexed($bifunction)
  {
  }

  public function max($default = null)
  {
  }

  public function median($default = null)
  {
  }

  public function min($default = null)
  {
  }

  public function none($predicate)
  {
  }

  public function onEach($action)
  {
  }

  public function onEachIndexed($action)
  {
  }

  public function pluck($path)
  {
  }

  public function partition($predicate)
  {
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
