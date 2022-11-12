<?php

namespace NoxImperium\Box\Types;

use Exception;
use ReflectionFunction;

class FunctionBox
{
  public static $PLACEHOLDER = "FUNCTIONBOXPLACEHOLDER";

  private $totalParams;
  private $params;
  private $function;

  public function __construct($function)
  {
    if (!is_callable($function)) throw new Exception("Not callable");

    $this->function = $function;
    $this->totalParams = $this->getTotalParams($function);
    $this->params = $this->generatePlaceholderParams($this->totalParams);
  }

  function curry(...$args)
  {
    $this->fillParams($args);
  }

  function call(...$args)
  {
    $totalPlaceholder = count(array_filter($this->params, fn ($val) => $val === FunctionBox::$PLACEHOLDER));
    if ($totalPlaceholder !== 0) throw new Exception("");
  }

  private function getTotalParams($function)
  {
    $reflection = new ReflectionFunction($function);

    return $reflection->getNumberOfRequiredParameters();
  }

  private function generatePlaceholderParams($total)
  {
    $params = [];
    for ($i = 0; $i < $total; $i++) {
      $params[] = FunctionBox::$PLACEHOLDER;
    }

    return $params;
  }

  private function getPlaceholderIndex($from)
  {
    for ($i = $from; $i < $this->totalParams; $i++) {
      if ($this->param[$i] === FunctionBox::$PLACEHOLDER) return $i;
    }

    return -1;
  }

  private function fillParams(...$args)
  {
    for ($i = 0; $i < $this->totalParams; $i++) {
      $target = $args[0];

      if ($target === FunctionBox::$PLACEHOLDER) {
        array_unshift($args);
        continue;
      }

      $index = $this->getPlaceholderIndex($i);
      if ($index !== -1) $this->params[$index] = array_shift($args);
    }
  }
}
