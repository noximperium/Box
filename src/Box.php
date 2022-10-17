<?php

namespace NoxImperium\Container;

use NoxImperium\Container\ImmutableList;
use NoxImperium\Container\MutableList;

class Box
{
  public static function createImmutableList($val)
  {
    return new ImmutableList($val);
  }

  public static function createMutableList($val)
  {
    return new MutableList($val);
  }
}
