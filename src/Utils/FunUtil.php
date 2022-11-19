<?php

namespace NoxImperium\Box\Utils;

define("__", "FUN_PLACEHOLDER");

use Closure;
use Exception;
use NoxImperium\Box\Types\Fun\CurriedFunction;
use ReflectionFunction;

class FunUtil
{
  public static function curry($function, ...$args)
  {
    return CurriedFunction::of($function, ...$args);
  }

  private function checkFunctionValidity($functions)
  {
    for ($i = 0; $i < count($functions); $i++) {
      $isNotCallable = !is_callable($functions[$i]);
      if ($isNotCallable) throw new Exception("Passed functions not callable.");

      if ($i == 0) continue;
      $isNotUnary = !FunUtil::isUnary($functions[$i]);
      if ($isNotUnary) throw new Exception("Passed functions other than first must be unary.");
    }
  }

  public static function compose(...$args)
  {
    FunUtil::checkFunctionValidity($args);

    return FunUtil::constructFunction(array_reverse($args));
  }

  public static function pipe(...$args)
  {
    FunUtil::checkFunctionValidity($args);

    return FunUtil::constructFunction($args);
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

  public static function isUnary($function)
  {
    $closure = Closure::fromCallable($function);
    $reflection = new ReflectionFunction($closure);

    return $reflection->getNumberOfRequiredParameters() === 1;
  }

  private static function constructFunction($functions)
  {
    return function (...$args) use ($functions) {
      $result = null;

      foreach ($functions as $index => $function) {
        if ($index === 0) $result = $function(...$args);
        else $result = $function($result);
      }

      return $result;
    };
  }
}
