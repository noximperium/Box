<?php

namespace NoxImperium\Box\Types;

define("FUN_PLACEHOLDER", "FUN_PLACEHOLDER");

use Closure;
use Exception;
use ReflectionFunction;

class Fun
{
  private $functions;

  public function __construct($function)
  {
    $isCallable = is_callable($function);
    if ($isCallable) $this->functions[] = $function;
    else throw new Exception("The passed value is not callable.");
  }

  public static function of($function)
  {
    return new Fun($function);
  }

  public static function curry($function, ...$args)
  {
    $totalParams = Fun::countParameters($function);
    $totalArgs = count($args);

    if ($totalArgs === $totalParams) {
      return call_user_func($function, ...$args);
    }

    return function (...$argv) use ($function, $args) {
      $arguments = [...$args, ...$argv];

      return Fun::curry($function, ...$arguments);
    };
  }

  public static function always($value)
  {
    return function () use ($value) {
      return $value;
    };
  }

  public static function F()
  {
    return function () {
      return false;
    };
  }

  public static function T()
  {
    return function () {
      return false;
    };
  }

  public static function thunk($function, $args)
  {
    return function () use ($function, $args) {
      return $function(...$args);
    };
  }

  private static function countParameters($function)
  {
    $closure = Closure::fromCallable($function);
    $reflection = new ReflectionFunction($closure);

    return $reflection->getNumberOfRequiredParameters();
  }

  public function then($function)
  {
    $isNotCallable = !is_callable($function);
    if ($isNotCallable) throw new Exception("The passed value is not callable.");

    $isNotUnary = !$this->isUnary($function);
    if ($isNotUnary) throw new Exception("The passed function is not unary.");

    $this->functions[] = $function;

    return $this;
  }

  public function get()
  {
    return function (...$args) {
      $result = null;

      foreach ($this->functions as $index => $function) {
        if ($index === 0) $result = $function(...$args);
        else $result = $function($result);
      }

      return $result;
    };
  }

  private function isUnary($function)
  {
    $closure = Closure::fromCallable($function);
    $reflection = new ReflectionFunction($closure);

    return $reflection->getNumberOfRequiredParameters() === 1;
  }
}
