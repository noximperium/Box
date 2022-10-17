<?php

namespace NoxImperium\Container\Interfaces;

interface BaseCollection
{
  /**
   * Returns true if all elements matches the given predicate.
   */
  public function all($predicate);

  /**
   * Returns true if at least one element matches the given predicate.
   */
  public function any($predicate);

  /**
   * Performs the given action on each element.
   */
  public function forEach($action);

  /**
   * Returns the element at the given index or throw exception if index not exists.
   */
  public function get($index);

  /**
   * Returns an element at the given index or null if index not exists.
   */
  public function getOrNull($index);

  /**
   * Returns an element at the given index or default if index not exists.
   */
  public function getOrElse($index, $default);

  /**
   * Returns an element at the given path or throw exception if path not found.
   */
  public function getOnPath($path);

  /**
   * Returns an element at the given path or null if path not found.
   */
  public function getOnPathOrNull($path);

  /**
   * Returns an element at the given path or default if path not found.
   */
  public function getOnPathOrElse($path, $default);

  /**
   * Returns elements at the given paths.
   */
  public function getOnPaths($paths);

  /**
   * Returns true if no elements match the given predicate.
   */
  public function none($predicate);

  /**
   * Returns current value of Collection
   */
  public function val();
}
