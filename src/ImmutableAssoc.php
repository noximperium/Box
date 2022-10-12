<?php

require __DIR__ . DIRECTORY_SEPARATOR . 'BaseListContainer.php';

class AssocContainer extends BaseListContainer
{
  public function __construct($init)
  {
    parent::__construct($init);
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

  public function put($key, $value): AssocContainer
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
}
