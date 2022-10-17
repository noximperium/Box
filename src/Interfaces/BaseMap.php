<?php

namespace NoxImperium\Box\Interfaces;

interface BaseMap extends BaseCollection
{
  /**
   * Returns true if the map contains the specified key.
   */
  public function containsKey($key);

  /**
   * Returns true if the map contains the specified value.
   */
  public function containsValue($value);

  /**
   * Returns true if the map contains the specified path.
   */
  public function containsPath($path);

  /**
   * Performs the given action on each element, providing key associated with the element.
   */
  public function forEachKeyed($action);

  /**
   * Returns the element at the given index and cast it to ImmutableMap
   */
  //public function getAsMap($key);

  /**
   * Returns the element at the given path and cast it to ImmutableMap
   */
  //public function getOnPathAsMap($path);

  /**
   * Returns a list of all keys in this map.
   */
  public function keys();

  /**
   * Create a new map with the this own properties merged with the own properties of the other map. 
   * If a key exists in both objects, the value from the this map will be used.
   */
  public function mergeLeft($other);

  /**
   * Create a new map with the this own properties merged with the own properties of the other map. 
   * If a key exists in both maps, the value from the this map will be used (if both of it is map too, they will be recursively merged).
   */
  public function mergeDeepLeft($other);

  /**
   * Create a new map with the this own properties merged with the own properties of the other map. 
   * If a key exists in both maps, the value from other map will be used.
   */
  public function mergeRight($other);

  /**
   * Create a new map with the this own properties merged with the own properties of the other map. 
   * If a key exists in both maps, the value from other map will be used (if both of it is map too, they will be recursively merged).
   */
  public function mergeDeepRight($other);

  /**
   * Create a new map with the this own properties merged with the own properties of the other map. 
   * If a key exists in both maps, resolver function will be used to resolve conflict.
   */
  public function mergeWith($map);

  /**
   * Create a new map with the this own properties merged with the own properties of the other map. 
   * If a key exists in both maps, resolver function will be used to resolve conflict (if both of it is map too, they will be recursively merged).
   */
  public function mergeDeepWith($map);

  /**
   * Returns a map with specified key transformed by transform function.
   */
  public function modify($key, $transform);

  /**
   * Returns a map with specified path transformed by transform function.
   */
  public function modifyPath($path, $transform);

  /**
   * Returns a map without specified key.
   */
  public function omit($path);

  /**
   * Performs the given action on each value and returns the map itself afterwards.
   */
  public function onEach($action);

  /**
   * Performs the given action on each value and key that associtated with it and returns the map itself afterwards.
   */
  public function onEachKeyed($action);

  /**
   * Associates the specified value with the specified key in the map.
   */
  public function put($key, $value);

  /**
   * Associates the specified value with the specified path in the map.
   */
  public function putOnPath($path, $value);

  /**
   * Removes the specified key and its corresponding value from this map.
   */
  public function remove($key);

  /**
   * Removes the specified path and its corresponding value from this map.
   */
  public function removeOnPath($key);

  /**
   * Runs the given function with the supplied object, then returns the object.
   */
  public function tap($action);

  /**
   * Returns current value of this `Box`.
   */
  public function val();

  /**
   * Returns a list of all values in this map.
   */
  public function values();
}
