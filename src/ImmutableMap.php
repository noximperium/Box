<?php

namespace NoxImperium\Container;

use Exception;

class ImmutableMap
{
  private $val;

  private function __construct($init)
  {
    $this->val = $init;
  }

  public static function of($init)
  {
    return new ImmutableMap($init);
  }

  public function entries()
  {
    return $this->val;
  }

  public function keys()
  {
    return array_keys($this->val);
  }

  public function values()
  {
    return array_values($this->val);
  }

  public function put($key, $value): ImmutableMap
  {
    $this->val += [$key => $value];

    return $this;
  }

  public function toPath($path)
  {
    $newAssoc = $this->val;

    foreach ($path as $key) {
      $exists = array_key_exists($key, $newAssoc);

      if (!$exists) throw new Exception("Assoc with key '$key' doesn't exists.");
      $newAssoc = $newAssoc[$key];
    }

    $this->val = $newAssoc;
  }

  public function val()
  {
    return $this->val;
  }
}
