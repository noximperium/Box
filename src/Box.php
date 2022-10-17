<?php

namespace NoxImperium\Box;

use NoxImperium\Box\ImmutableList;
use NoxImperium\Box\MutableList;

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

  public static function immutableMap($val)
  {
    return new ImmutableMap($val);
  }

  public static function mutableMap($val)
  {
    return new MutableMap($val);
  }
}
