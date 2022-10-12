<?php

namespace Src;

class Container
{
  public static function array($init)
  {
    return new ArrayContainer($init);
  }

  public static function assoc($init)
  {
    return new AssocContainer($init);
  }
}
