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
    if (get_class($value) === "NoxImperium\\Box\\Types\\Either\\Right") return true;

    return false;
  }

  public static function isLeft($value)
  {
    if (get_class($value) === "NoxImperium\\Box\\Types\\Either\\Left") return true;

    return false;
  }

  public static function isTryer($value)
  {
    return Helper::isSuccess($value) || Helper::isFailure($value);
  }

  public static function isSuccess($value)
  {
    if (get_class($value) === "NoxImperium\\Box\\Types\\Tryer\\Success") return true;

    return false;
  }

  public static function isFailure($value)
  {
    if (get_class($value) === "NoxImperium\\Box\\Types\\Tryer\\Failure") return true;

    return false;
  }
}
