<?php

namespace NoxImperium\Box;

use NoxImperium\Box\Functions\ListFunction;
use NoxImperium\Box\Interfaces\BaseList;

class ImmutableList implements BaseList
{
  private $val;
  private $listFunction;

  public function __construct($val)
  {
    $this->val = $val;
    $this->listFunction = new ListFunction();
  }

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
    return $this->listFunction->all($predicate, $this->val);
  }

  public function any($predicate)
  {
    return $this->listFunction->any($predicate, $this->val);
  }

  public function average()
  {
    return $this->listFunction->average($this->val);
  }

  public function append($value)
  {
    $result = $this->listFunction->append($value, $this->val);

    return new ImmutableList($result);
  }

  public function appendAll($list)
  {
    $result = $this->listFunction->appendAll($list, $this->val);

    return new ImmutableList($result);
  }

  public function contains($value)
  {
    return $this->listFunction->contains($value, $this->val);
  }

  public function containsAll($values)
  {
    return $this->listFunction->containsAll($values, $this->val);
  }

  public function collectBy($keySelector)
  {
    $result = $this->listFunction->collectBy($keySelector, $this->val);

    return new ImmutableList($result);
  }

  public function count($predicate)
  {
    return $this->listFunction->count($predicate, $this->val);
  }

  public function distinct()
  {
    $result = $this->listFunction->distinct($this->val);

    return new ImmutableList($result);
  }

  public function distinctBy($keySelector)
  {
    $result = $this->listFunction->distinctBy($keySelector, $this->val);

    return new ImmutableList($result);
  }

  public function drop($n)
  {
    $result = $this->listFunction->drop($n, $this->val);

    return new ImmutableList($result);
  }

  public function dropWhile($predicate)
  {
    $result = $this->listFunction->dropWhile($predicate, $this->val);

    return new ImmutableList($result);
  }

  public function dropLast($n)
  {
    $result = $this->listFunction->dropLast($n, $this->val);

    return new ImmutableList($result);
  }

  public function dropLastWhile($predicate)
  {
    $result = $this->listFunction->dropLastWhile($predicate, $this->val);

    return new ImmutableList($result);
  }

  public function dropRepeats()
  {
    $result = $this->listFunction->dropRepeats($this->val);

    return new ImmutableList($result);
  }

  public function dropRepeatsBy($predicate)
  {
    $result = $this->listFunction->dropRepeatsBy($predicate, $this->val);

    return new ImmutableList($result);
  }

  public function endsWith($sublist)
  {
    return $this->listFunction->endsWith($sublist, $this->val);
  }

  public function filter($predicate)
  {
    $result = $this->listFunction->filter($predicate, $this->val);

    return new ImmutableList($result);
  }

  public function filterIndexed($predicate)
  {
    $result = $this->listFunction->filterIndexed($predicate, $this->val);

    return new ImmutableList($result);
  }

  public function filterNot($predicate)
  {
    $result = $this->listFunction->filterNot($predicate, $this->val);

    return new ImmutableList($result);
  }

  public function filterNotIndexed($predicate)
  {
    $result = $this->listFunction->filterNotIndexed($predicate, $this->val);

    return new ImmutableList($result);
  }

  public function find($predicate)
  {
    return $this->listFunction->find($predicate, $this->val);
  }

  public function findLast($predicate)
  {
    return $this->listFunction->findLast($predicate, $this->val);
  }

  public function first()
  {
    return $this->listFunction->first($this->val);
  }

  public function firstOrNull()
  {
    return $this->listFunction->firstOrNull($this->val);
  }

  public function flatten()
  {
    $result = $this->listFunction->flatten($this->val);

    return new ImmutableList($result);
  }

  public function forEach($action)
  {
    $this->listFunction->forEach($action, $this->val);
  }

  public function forEachIndexed($action)
  {
    $this->listFunction->forEachIndexed($action, $this->val);
  }

  public function fold($initial, $operation)
  {
    return $this->listFunction->fold($initial, $operation, $this->val);
  }

  public function foldIndexed($initial, $operation)
  {
    return $this->listFunction->foldIndexed($initial, $operation, $this->val);
  }

  public function foldRight($initial, $operation)
  {
    return $this->listFunction->foldRight($initial, $operation, $this->val);
  }

  public function foldRightIndexed($initial, $operation)
  {
    return $this->listFunction->foldRightIndexed($initial, $operation, $this->val);
  }

  public function get($index)
  {
    return $this->listFunction->get($index, $this->val);
  }

  public function getOrNull($index)
  {
    return $this->listFunction->getOrNull($index, $this->val);
  }

  public function getOrElse($index, $default)
  {
    return $this->listFunction->getOrElse($index, $default, $this->val);
  }

  public function getOnPath($path)
  {
    return $this->listFunction->getOnPath($path, $this->val);
  }

  public function getOnPathOrNull($path)
  {
    return $this->listFunction->getOnPathOrNull($path, $this->val);
  }

  public function getOnPathOrElse($path, $default)
  {
    return $this->listFunction->getOnPathOrElse($path, $default, $this->val);
  }

  public function getOnPaths($paths)
  {
    return $this->listFunction->getOnPath($paths, $this->val);
  }

  public function groupBy($groupKeySelector, $valueTransform = null)
  {
    $result = $this->listFunction->groupBy($groupKeySelector, $valueTransform, $this->val);

    return new ImmutableList($result);
  }

  public function groupByKeyed($groupKeySelector, $keyTransform, $valueTransform = null)
  {
    $result = $this->listFunction->groupByKeyed($groupKeySelector, $keyTransform, $valueTransform, $this->val);

    return new ImmutableList($result);
  }

  public function head()
  {
    return $this->listFunction->head($this->val);
  }

  public function indexOf($element)
  {
    return $this->listFunction->indexOf($element, $this->val);
  }

  public function indexOfFirst($predicate)
  {
    return $this->listFunction->indexOfFirst($predicate, $this->val);
  }

  public function indexOfLast($predicate)
  {
    return $this->listFunction->indexOfLast($predicate, $this->val);
  }

  public function last()
  {
    return $this->listFunction->last($this->val);
  }

  public function lastIndexOf($element)
  {
    return $this->listFunction->lastIndexOf($element, $this->val);
  }

  public function map($transform)
  {
    $result = $this->listFunction->map($transform, $this->val);

    return new ImmutableList($result);
  }

  public function mapNotNull($transform)
  {
    $result = $this->listFunction->mapNotNull($transform, $this->val);

    return new ImmutableList($result);
  }

  public function mapIndexed($transform)
  {
    $result = $this->listFunction->mapIndexed($transform, $this->val);

    return new ImmutableList($result);
  }

  public function mapIndexedNotNull($transform)
  {
    $result = $this->listFunction->mapIndexedNotNull($transform, $this->val);

    return new ImmutableList($result);
  }

  public function max()
  {
    return $this->listFunction->max($this->val);
  }

  public function min()
  {
    return $this->listFunction->max($this->val);
  }

  public function none($predicate)
  {
    return $this->listFunction->none($predicate, $this->val);
  }

  public function onEach($action)
  {
    $this->listFunction->forEach($action, $this->val);

    return $this;
  }

  public function onEachIndexed($action)
  {
    $this->listFunction->forEachIndexed($action, $this->val);

    return $this;
  }

  public function pluck($path, $default = null)
  {
    $result = $this->listFunction->pluck($path, $default, $this->val);

    return new ImmutableList($result);
  }

  public function partition($predicate)
  {
    $result = $this->listFunction->partition($predicate, $this->val);

    return new ImmutableList($result);
  }

  public function prepend($value)
  {
    $result = $this->listFunction->prepend($value, $this->val);

    return new ImmutableList($result);
  }

  public function prependAll($list)
  {
    $result = $this->listFunction->prependAll($list, $this->val);

    return new ImmutableList($result);
  }

  public function reduce($operation)
  {
    $result = $this->listFunction->reduce($operation, $this->val);

    return new ImmutableList($result);
  }

  public function reduceIndexed($operation)
  {
    $result = $this->listFunction->reduceIndexed($operation, $this->val);

    return new ImmutableList($result);
  }

  public function reduceRight($operation)
  {
    $result = $this->listFunction->reduceRight($operation, $this->val);

    return new ImmutableList($result);
  }

  public function reduceRightIndexed($operation)
  {
    $result = $this->listFunction->reduceRightIndexed($operation, $this->val);

    return new ImmutableList($result);
  }

  public function reverse()
  {
    $result = $this->listFunction->reverse($this->val);

    return new ImmutableList($result);
  }

  public function runningFold($initial, $operation)
  {
    $result = $this->listFunction->runningFold($initial, $operation, $this->val);

    return new ImmutableList($result);
  }

  public function runningFoldIndexed($initial, $operation)
  {
    $result = $this->listFunction->runningFoldIndexed($initial, $operation, $this->val);

    return new ImmutableList($result);
  }

  public function runningFoldRight($initial, $operation)
  {
    $result = $this->listFunction->runningFoldRight($initial, $operation, $this->val);

    return new ImmutableList($result);
  }

  public function runningFoldRightIndexed($initial, $operation)
  {
    $result = $this->listFunction->runningFoldRightIndexed($initial, $operation, $this->val);

    return new ImmutableList($result);
  }

  public function runningReduce($operation)
  {
    $result = $this->listFunction->runningReduce($operation, $this->val);

    return new ImmutableList($result);
  }

  public function runningReduceIndexed($operation)
  {
    $result = $this->listFunction->runningReduceIndexed($operation, $this->val);

    return new ImmutableList($result);
  }

  public function runningReduceRight($operation)
  {
    $result = $this->listFunction->runningReduceRight($operation, $this->val);

    return new ImmutableList($result);
  }

  public function runningReduceRightIndexed($operation)
  {
    $result = $this->listFunction->runningReduceRightIndexed($operation, $this->val);

    return new ImmutableList($result);
  }

  public function sum()
  {
    return $this->listFunction->sum($this->list);
  }

  public function slice($from, $to)
  {
    $result = $this->listFunction->slice($from, $to, $this->val);

    return new ImmutableList($result);
  }

  public function sortBy($comparator)
  {
    $result = $this->listFunction->sortBy($comparator, $this->val);

    return new ImmutableList($result);
  }

  public function splitAt($index)
  {
    $result = $this->listFunction->splitAt($index, $this->val);

    return new ImmutableList($result);
  }

  public function splitEvery($length)
  {
    $result = $this->listFunction->splitEvery($length, $this->val);

    return new ImmutableList($result);
  }

  public function startsWith($sublist)
  {
    return $this->listFunction->startsWith($sublist, $this->val);
  }

  public function take($n)
  {
    $result = $this->listFunction->take($n, $this->val);

    return new ImmutableList($result);
  }

  public function takeWhile($predicate)
  {
    $result = $this->listFunction->takeWhile($predicate, $this->val);

    return new ImmutableList($result);
  }

  public function takeLast($n)
  {
    $result = $this->listFunction->takeLast($n, $this->val);

    return new ImmutableList($result);
  }

  public function takeLastWhile($predicate)
  {
    $result = $this->listFunction->takeLastWhile($predicate, $this->val);

    return new ImmutableList($result);
  }

  public function tap($action)
  {
    $action($this->val);

    return $this;
  }

  public function tail()
  {
    $result = $this->listFunction->tail($this->val);

    return new ImmutableList($result);
  }

  public function unzip()
  {
    $result = $this->listFunction->unzip($this->val);

    return new ImmutableList($result);
  }

  public function where($key, $value)
  {
    $result = $this->listFunction->where($key, $value, $this->val);

    return new ImmutableList($result);
  }

  public function whereComparison($key, $operator, $value)
  {
    $result = $this->listFunction->whereComparison($key, $operator, $value, $this->val);

    return new ImmutableList($result);
  }

  public function whereBetween($key, $from, $to)
  {
    $result = $this->listFunction->whereBetween($key, $from, $to, $this->val);

    return new ImmutableList($result);
  }

  public function whereNotBetween($key, $from, $to)
  {
    $result = $this->listFunction->whereNotBetween($key, $from, $to, $this->val);

    return new ImmutableList($result);
  }

  public function whereIn($key, $values)
  {
    $result = $this->listfunction->wherein($key, $values, $this->val);

    return new immutablelist($result);
  }

  public function whereNotIn($key, $values)
  {
    $result = $this->listfunction->whereNotIn($key, $values, $this->val);

    return new immutablelist($result);
  }

  public function val()
  {
    return $this->val;
  }

  public function zip($other)
  {
    $result = $this->listFunction->zip($other, $this->val);

    return new ImmutableList($result);
  }

  public function zipWith($other, $transform)
  {
    $result = $this->listFunction->zipWith($other, $transform, $this->val);

    return new ImmutableList($result);
  }
}
