<?php

namespace NoxImperium\Box\Types;

class PartialFunction
{
  private $partials;

  public function __construct($partials)
  {
    $this->partials = $partials;
  }

  public function apply($input)
  {
    foreach ($this->partials as $partial) {
      if ($partial[0]($input) === true) return $partial[1];
    }

    return null;
  }
}
