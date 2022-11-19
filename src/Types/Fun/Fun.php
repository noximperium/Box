<?php

namespace NoxImperium\Box\Types\Fun;

use Exception;
use NoxImperium\Box\Utils\FunUtil;

class Fun
{
  private $function;

  private function __construct($function)
  {
    $isCallable = is_callable($function);
    if ($isCallable) $this->function = $function;
    else throw new Exception("The passed value is not callable.");
  }

  public static function of($function)
  {
    return new Fun($function);
  }

  public function then($function)
  {
    $isNotCallable = !is_callable($function);
    if ($isNotCallable) throw new Exception("The passed value is not callable.");

    $isNotUnary = !FunUtil::isUnary($function);
    if ($isNotUnary) throw new Exception("The passed function is not unary.");

    $currentFunction = $this->function;
    $newFn = function (...$args) use ($currentFunction, $function) {
      $result = $currentFunction(...$args);

      return $function($result);
    };

    return Fun::of($newFn);
  }

  public function __invoke(...$args)
  {
    $fn = $this->function;

    return $fn(...$args);
  }
}
