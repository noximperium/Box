<?php

namespace NoxImperium\Box\Types\Fun;

use Closure;
use ReflectionFunction;

class CurriedFunction
{
  private $function;
  private $totalParams;
  private $args;

  private function __construct($function, $totalParams, $args)
  {
    $this->function = $function;
    $this->totalParams = $totalParams;
    $this->args = $args;
  }

  public function __invoke(...$args)
  {
    $processedArgs = CurriedFunction::fillPlaceholder($this->args, $args);
    $filledArgs = $processedArgs[0];
    $remainingPassedArgs = $processedArgs[1];

    $filteredRemainingPassedArgs = CurriedFunction::filterPlaceholder($remainingPassedArgs);

    $newArgs = [...$filledArgs, ...$filteredRemainingPassedArgs];

    $newArgsLength = count($newArgs);

    if ($newArgsLength >= $this->totalParams) {
      $fn = $this->function;

      return $fn(...$newArgs);
    }

    return CurriedFunction::of($this->function, ...$newArgs);
  }

  public static function of($function, ...$args)
  {
    $totalParams = CurriedFunction::countParameters($function);
    $filteredArgs = CurriedFunction::filterPlaceholder($args);
    $totalFilteredArgs = count($filteredArgs);

    if ($totalFilteredArgs >= $totalParams) return $function(...$args);

    return new CurriedFunction($function, $totalParams, $args);
  }

  private static function countParameters($function)
  {
    $closure = Closure::fromCallable($function);
    $reflection = new ReflectionFunction($closure);

    return $reflection->getNumberOfRequiredParameters();
  }

  private function fillPlaceholder($args, $argv)
  {
    foreach ($args as $index => $arg) {
      if ($arg == __) $args[$index] = array_shift($argv);
    }

    return [$args, $argv];
  }

  private function filterPlaceholder($args)
  {
    return array_filter($args, function ($val) {
      return $val != __;
    });
  }
}
