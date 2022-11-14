<?php

namespace NoxImperium\Box;

use NoxImperium\Box\Types\ListType;
use NoxImperium\Box\Types\MapType;
use NoxImperium\Box\Types\TryType\Success;
use NoxImperium\Box\Types\TryType\TryType;

class Box
{
  public static function list($val)
  {
    return new ListType($val);
  }

  public static function map($val)
  {
    return new MapType($val);
  }

  public static function either($val)
  {
    return new Success($val);
  }

  public static function try($computation)
  {
    return TryType::on($computation);
  }
}
