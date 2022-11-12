<?php

namespace NoxImperium\Box;

class Helper
{
  public static function isEither($value)
  {
    return Helper::isLeft($value) || Helper::isRight($value);
  }

  public static function isRight($value)
  {
    if (get_class($value) === "NoxImperium\\Box\\Types\\Right") return true;

    return false;
  }

  public static function isLeft($value)
  {
    if (get_class($value) === "NoxImperium\\Box\\Types\\Left") return true;

    return false;
  }
}
