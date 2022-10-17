<?php

namespace NoxImperium\Container;

class MutableList extends BaseListImpl
{
  public function __construct($val)
  {
    parent::__construct($val);
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

  public function append($value)
  {
    parent::append($value);

    return $this;
  }

  public function appendAll($list)
  {
    parent::appendAll($list);

    return $this;
  }

  public function collectBy($keySelector)
  {
    parent::collectBy($keySelector);

    return $this;
  }

  public function distinct()
  {
    parent::distinct();

    return $this;
  }

  public function distinctBy($keySelector)
  {
    parent::distinctBy($keySelector);

    return $this;
  }

  public function drop($n)
  {
  }

  public function dropWhile($predicate)
  {
  }

  public function dropLast($n)
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
    parent::getOnPath($path);

    return $this;
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

  public function groupBy($groupKeySelector, $valueTransform = null)
  {
    parent::groupBy($groupKeySelector, $valueTransform);

    return $this;
  }

  public function groupByKeyed($groupKeySelector, $keyTransform, $valueTransform = null)
  {
    parent::groupByKeyed($groupKeySelector, $keyTransform, $valueTransform = null);

    return $this;
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

  public function pluck($path, $default = null)
  {
    parent::pluck($path, $default);

    return $this;
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
