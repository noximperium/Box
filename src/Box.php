<?php

namespace NoxImperium\Container;

use NoxImperium\Container\ImmutableList;
use NoxImperium\Container\MutableList;

class Box
{
  public static function immutableList($val)
  {
    return new ImmutableList($val);
  }

  public static function mutableList($val)
  {
    return new MutableList($val);
  }
}
