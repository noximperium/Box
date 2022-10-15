<?php

namespace NoxImperium\Container\Interfaces;

interface BaseList extends BaseCollection
{
  /**
   * Adds the specified element to the end of this list.
   */
  public function append($value);

  /**
   * Adds all of the elements of the specified collection to the end of this list.
   */
  public function appendAll($list);

  /**
   * Returns average value of this list. If this list contains null value, it will be substituted with supplied default.
   */
  public function average($default = null);

  /**
   * Returns true if element is found in the list.
   */
  public function contains($value);

  /**
   * Checks if all elements in the specified list are contained in this list.
   */
  public function containsAll($values);

  /**
   * Splits a list into sub-lists, based on the result of calling a key-returning function on each element.
   */
  public function collectBy($selector);

  /**
   * Returns the number of items in a given list matching the predicate.
   */
  public function count($predicate);

  /**
   * Returns a list containing only distinct elements from the given collection.
   */
  public function distinct();

  /**
   * Returns a list containing only elements from the given collection 
   * having distinct keys returned by the given selector function.
   */
  public function distinctBy($predicate);

  /**
   * Returns a list containing all elements except first n elements.
   */
  public function drop($n);

  /**
   * Returns a list containing all elements except first elements that satisfy the given predicate.
   */
  public function dropWhile($predicate);

  /**
   * Returns a list containing all elements except last n elements.
   */
  public function dropLast($size);

  /**
   * Returns a list containing all elements except last elements that satisfy the given predicate.
   */
  public function dropLastWhile($predicate);

  /**
   * Returns a new list without any consecutively repeating elements (compared with === operator). 
   */
  public function dropRepeats();

  /**
   * Returns a new list without any consecutively repeating elements (compared with predicate supplied). 
   */
  public function dropRepeatsBy($predicate);

  /**
   * Checks if a list ends with the provided sublist.
   */
  public function endsWith($sublist);

  /**
   * Returns a list containing only elements matching the given predicate.
   */
  public function filter($bipredicate);

  /**
   * Returns a list containing only elements not matching the given predicate.
   */
  public function filterNot($bipredicate);

  /**
   * Returns the first element matching the given predicate, or null if no such element was found.
   */
  public function find($predicate);

  /**
   * Returns the last element matching the given predicate, or null if no such element was found.
   */
  public function findLast($predicate);

  /**
   * Returns first element of this list.
   */
  public function first();

  /**
   * Returns a single list of all elements from all collections in the given collection.
   */
  public function flatten();

  /**
   * Performs the given action on each element, providing sequential index with the element.
   */
  public function forEachIndexed($action);

  /**
   * Accumulates value starting with initial value and 
   * applying operation from left to right to current accumulator value and each element.
   */
  public function fold($initial, $operation);

  /**
   * Accumulates value starting with initial value and 
   * applying operation from left to right to current accumulator value and each element 
   * with its index in the original collection.
   */
  public function foldIndexed($initial, $operation);

  /**
   * Accumulates value starting with initial value and 
   * applying operation from right to left to current accumulator value and each element.
   */
  public function foldRight($initial, $operation);

  /**
   * Accumulates value starting with initial value and 
   * applying operation from right to left to current accumulator value and each element 
   * with its index in the original collection.
   */
  public function foldRightIndexed($initial, $operation);

  /**
   * Groups elements of the original list by the key returned by the given groupKeySelector function applied to each element 
   * and returns a map where each group key is associated with a list of corresponding elements.
   */
  public function groupBy($groupKeySelector, $valueTransform);

  /**
   * Groups elements of the original list by the key returned by the given groupKeySelector function applied to each element 
   * and returns a map where each group key is associated with a map with key returned by keyTransform with corresponding element.
   */
  public function groupByKeyed($groupKeySelector, $keyTransform, $valueTransform);

  /**
   * Returns the first element of this list.
   */
  public function head();

  /**
   * Returns first index of element, or -1 if the list does not contain element.
   */
  public function indexOf($element);

  /**
   * Returns index of the first element matching the given predicate, 
   * or -1 if the list does not contain such element.
   */
  public function indexOfFirst($predicate);

  /**
   * Returns index of the last element matching the given predicate, or -1 if the collection does not contain such element.
   */
  public function indexOfLast($predicate);

  /**
   * Returns last element of this list.
   */
  public function last();

  /**
   * Returns last index of element, or -1 if the list does not contain element.
   */
  public function lastIndexOf($element);

  /**
   * Returns a list containing the results of applying the given transform function 
   * to each element in the original list.
   */
  public function map($function);

  /**
   * Returns a list containing only the non-null results of applying the given 
   * transform function to each element in the original list.
   */
  public function mapNotNull($function);

  /**
   * Returns a list containing the results of applying the given transform 
   * function to each element and its index in the original list.
   */
  public function mapIndexed($bifunction);

  /**
   * Returns max value of this list. If this list contains null value, it will be substituted with supplied default.
   */
  public function max($default = null);

  /**
   * Returns median value of this list. If this list contains null value, it will be substituted with supplied default.
   */
  public function median($default = null);

  /**
   * Returns min value of this list. If this list contains null value, it will be substituted with supplied default.
   */
  public function min($default = null);

  /**
   * Performs the given action on each element and returns the list itself afterwards.
   */
  public function onEach($action);

  /**
   * Performs the given action on each element, providing sequential index with the element, 
   * and returns the collection itself afterwards.
   */
  public function onEachIndexed($biconsumer);

  /**
   * Returns a new list by plucking the property on specified path of every object in this list.
   */
  public function pluck($path);

  /**
   * Splits the original list into pair of lists, where first list contains elements for which predicate yielded true, 
   * while second list contains elements for which predicate yielded false.
   */
  public function partition($predicate);

  /**
   * Adds the specified element to the start of this list.
   */
  public function prepend($value);

  /**
   * Adds all of the elements of the specified collection to the start of this list.
   */
  public function prependAll($list);

  /**
   * Accumulates value starting with the first element and applying 
   * operation from left to right to current accumulator value and each element.
   */
  public function reduce($operation);

  /**
   * Accumulates value starting with the first element and applying 
   * operation from left to right to current accumulator value and each element 
   * with its index in the original list.
   */
  public function reduceIndexed($operation);

  /**
   * Accumulates value starting with the last element and applying 
   * operation from right to left to current accumulator value and each element.
   */
  public function reduceRight($operation);

  /**
   * Accumulates value starting with the last element and applying 
   * operation from right to left to current accumulator value and each element 
   * with its index in the original list.
   */
  public function reduceRightIndexed($operation);

  /**
   * Returns a list with elements in reversed order.
   */
  public function reverse();

  /**
   * Returns a list containing successive accumulation values generated by applying operation 
   * from left to right to each element and current accumulator value that starts with initial value.
   */
  public function runningFold($initial, $operation);

  /**
   * Returns a list containing successive accumulation values generated by applying operation 
   * from left to right to each element, its index in the original list and 
   * current accumulator value that starts with initial value.
   */
  public function runningFoldIndexed($initial, $operation);

  /**
   * Returns a list containing successive accumulation values generated by applying operation 
   * from right to left to each element and current accumulator value that starts with lainitialst value.
   */
  public function runningFoldRight($initial, $operation);

  /**
   * Returns a list containing successive accumulation values generated by applying operation 
   * from right to left to each element, its index in the original list and 
   * current accumulator value that starts with initial value.
   */
  public function runningFoldIndexedRight($initial, $operation);

  /**
   * Returns a list containing successive accumulation values generated by applying operation 
   * from left to right to each element and current accumulator value that starts with the 
   * first element of this list.
   */
  public function runningReduce($operation);

  /**
   * Returns a list containing successive accumulation values generated by applying operation 
   * from left to right to each element, its index in the original list and current accumulator 
   * value that starts with the first element of this list.
   */
  public function runningReduceIndexed($operation);

  /**
   * Returns a list containing successive accumulation values generated by applying operation 
   * from right to left to each element and current accumulator value that starts with the 
   * last element of this list.
   */
  public function runningReduceRight($operation);

  /**
   * Returns a list containing successive accumulation values generated by applying operation 
   * from right to left to each element, its index in the original list and current accumulator 
   * value that starts with the last element of this list.
   */
  public function runningReduceIndexedRight($operation);

  /**
   * Returns the sum of all values in this list.
   */
  public function sum();

  /**
   * Checks if a list starts with the provided sublist.
   */
  public function startsWith($sublist);

  /**
   * Returns a list containing elements at specified from and to index.
   */
  public function slice($from, $to);

  /**
   * Sorts elements in the list according to the order specified with comparator.
   */
  public function sortBy($comparator);

  /**
   * Splits a list at a given index.
   */
  public function splitAt();

  /**
   * Splits a list into slices of the specified length.
   */
  public function splitEvery($length);

  /**
   * Returns a list containing first n elements.
   */
  public function take($n);

  /**
   * Returns a list containing first elements satisfying the given predicate.
   */
  public function takeWhile($predicate);

  /**
   * Returns a list containing last n elements.
   */
  public function takeLast($n);

  /**
   * Returns a list containing last elements satisfying the given predicate.
   */
  public function takeLastWhile($predicate);

  /**
   * Returns all but the first element of this list.
   */
  public function tail();

  /**
   * Returns a pair of lists, where first list is built from the first values of each pair from this collection, 
   * second list is built from the second values of each pair from this collection.
   */
  public function unzip();

  /**
   * Returns a list of values built from the elements of this list and the other list with the same index.
   * If transform function is given, it will be applied to each pair of elements. 
   * The returned list has length of the shortest collection.
   */
  public function zip($other, $transform = null);
}
