<?php

namespace NoxImperium\Box;

use NoxImperium\Box\Types\ListType\ListType;
use NoxImperium\Box\Types\MapType\MapType;
use NoxImperium\Box\Types\TryType\Success;
use NoxImperium\Box\Types\TryType\TryType;

class Box
{
  public static function ofList($val)
  {
    return new ListType($val);
  }

  public static function ofMap($val)
  {
    return new MapType($val);
  }

  public static function ofEither($val)
  {
    return new Success($val);
  }

  public static function ofTry($computation)
  {
    return TryType::on($computation);
  }
}
