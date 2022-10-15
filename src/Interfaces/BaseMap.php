<?php

namespace NoxImperium\Container\Interfaces;

interface BaseMap extends BaseCollection
{
  public function containsPath($path);
  public function filterKeys($predicate);
  public function filterValues($predicate);

  // Classified
  public function foldKeyed($trifunction);
  public function foldRightKeyed($trifunction);
  public function getOrPut($index, $default);
  public function mapKeyed($bifunction);
  public function modify($key, $bifunction);
  public function modifyPath($path, $bifunction);
  public function onEachKeyed($biconsumer);
  public function omit($path);
  public function put($key, $value);
  public function putAll($assoc);
  public function remove($key);

  public function get($key);
  public function getOrNull($key);

  public function all($bipredicate);
  public function any($bipredicate);
  public function contains($key);
  public function count($bipredicate);
  public function filter($bipredicate);
  public function filterNot($bipredicate);
  public function fold($trifunction);
  public function foldRight($trifunction);
  public function forEach($biconsumer);
  public function groupBy($groupKeySelector, $valueTransform);
  public function groupByKeyed($groupKeySelector, $keyTransform, $valueTransform);
  public function head();
  public function keys();
  public function map($function);
  public function mapNotNull($function);
  public function none($bipredicate);
  public function path($path);
  public function onEach($biconsumer);
  public function reduce($trifunction);
  public function reduceRight($trifunction);
  public function tail();
  public function values();
}
