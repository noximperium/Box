<?php

namespace NoxImperium\Box\Interfaces;

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
   * Returns average value of this list.
   */
  public function average();

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
  public function filter($predicate);

  /**
   * Returns a list containing only elements matching the given predicate (receives additional index).
   */
  public function filterIndexed($predicate);

  /**
   * Returns a list containing only elements not matching the given predicate.
   */
  public function filterNot($predicate);

  /**
   * Returns a list containing only elements matching the given predicate (receives additional index).
   */
  public function filterNotIndexed($predicate);

  /**
   * Returns the first element matching the given predicate, or null if no such element was found.
   */
  public function find($predicate);

  /**
   * Returns the last element matching the given predicate, or null if no such element was found.
   */
  public function findLast($predicate);

  /**
   * Returns index of the first element matching the given value, 
   * or -1 if the list does not contain such element.
   */
  public function findIndex($element);

  /**
   * Returns index of the last element matching the given value, or -1 if the collection does not contain such element.
   */
  public function findLastIndex($element);


  /**
   * Returns first element of this list or throw exception if empty.
   */
  public function first();

  /**
   * Returns first element of this list or null if empty.
   */
  public function firstOrNull();

  /**
   * Returns a single list of all elements from all collections in the given collection.
   */
  public function flatten();

  /**
   * Performs the given action on each element, providing key associated with the element.
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
   * Returns the element at the given index and cast it to ImmutableList
   */
  //public function getAsList($index);

  /**
   * Returns the element at the given path and cast it to ImmutableList
   */
  //public function getOnPathAsList($index);

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
   * Insert value at specified index.
   */
  public function insert($index, $value);

  /**
   * Insert all values at specified index.
   */
  public function insertAll($index, $values);

  /**
   * Returns last element of this list.
   */
  public function last();

  /**
   * Returns a list containing the results of applying the given transform function 
   * to each element in the original list.
   */
  public function map($transform);

  /**
   * Returns a list containing the results of applying the given transform 
   * function to each element and its index in the original list.
   */
  public function mapIndexed($transform);

  /**
   * Returns a list containing only the non-null results of applying the given 
   * transform function to each element in the original list.
   */
  public function mapIndexedNotNull($transform);

  /**
   * Returns a list containing only the non-null results of applying the given 
   * transform function to each element in the original list.
   */
  public function mapNotNull($transform);

  /**
   * Returns max value of this list. 
   */
  public function max();

  /**
   * Returns min value of this list. 
   */
  public function min();

  /**
   * Move element from `$from` index to `$to` index.
   */
  public function move($from, $to);

  /**
   * Performs the given action on each element and returns the list itself afterwards.
   */
  public function onEach($action);

  /**
   * Performs the given action on each element, providing sequential index with the element, 
   * and returns the collection itself afterwards.
   */
  public function onEachIndexed($action);

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
   * Replace element at specified index with supplied value.
   */
  public function replace($index, $value);

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
  public function runningFoldRightIndexed($initial, $operation);

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
  public function runningReduceRightIndexed($operation);

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
  public function splitAt($index);

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
   * Runs the given function with the supplied object, then returns the object.
   */
  public function tap($action);

  /**
   * Returns current value of this `Box`.
   */
  public function val();

  /**
   * Returns a pair of lists, where first list is built from the first values of each pair from this collection, 
   * second list is built from the second values of each pair from this collection.
   */
  public function unzip();

  /**
   * Filters the list by a given key and value pair.
   */
  public function where($key, $value);

  /**
   * Filters the list by a given key, operator and value pair.
   */
  public function whereComparison($key, $operator, $value);

  /**
   * Filters the list by determining if a value of specified key is within a given range.
   */
  public function whereBetween($key, $from, $to);

  /**
   * Filters the list by determining if a value of specified key is not within a given range.
   */
  public function whereNotBetween($key, $from, $to);

  /**
   * Filters the list by determining if a value of specified key is contained within the given array of values.
   */
  public function whereIn($key, $values);

  /**
   * Filters the list by determining if a value of specified key is not contained within the given array of values.
   */
  public function whereNotIn($key, $values);

  /**
   * Returns a list of values built from the elements of this list and the other list with the same index.
   * If transform function is given, it will be applied to each pair of elements. 
   * The returned list has length of the shortest collection.
   */
  public function zip($other);

  /**
   * Creates a new list out of the two supplied by applying the function to each equally-positioned pair in the lists. 
   * The returned list is truncated to the length of the shorter of the two input lists.
   */
  public function zipWith($other, $transform);
}
