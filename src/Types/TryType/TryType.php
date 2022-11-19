<?php

namespace NoxImperium\Box\Types\TryType;

use Exception;
use NoxImperium\Box\Utils\TypeChecker;

abstract class TryType
{
  protected $value;

  public abstract function filter($predicate);
  public abstract function collect($pairs);
  public abstract function flatMap($function);
  public abstract function map($function);
  public abstract function flatten();
  public abstract function foreach($function);
  public abstract function get();
  public abstract function getOrElse($default);
  public abstract function isFailure();
  public abstract function isSuccess();
  public abstract function orElse($default);
  public abstract function recover($recoverer);
  public abstract function recoverWith($recoverer);

  public static function on($computation)
  {
    try {
      $result = $computation();
    } catch (Exception $e) {
      return new Failure($e);
    }

    return new Success($result);
  }

  public function fold($onFailure, $onSuccess)
  {
    if ($this->isFailure()) return $onFailure($this->value);

    return $onSuccess($this->value);
  }

  public function transform($onSuccess, $onFailure)
  {
    if ($this->isFailure()) $result = $onFailure($this->value);
    else $result = $onSuccess($this->value);

    $isTryer = TypeChecker::isTryer($result);
    if ($isTryer) return $result;

    throw new Exception("The passed value is neither Success or Failure.");
  }
}
