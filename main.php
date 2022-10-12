<?php

require __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'ImmutableArray.php';

$array = [1, [2, 3, [4], [5, 6, 7, [8]], [9]]];
$array2 = [10, 10, 80, 70, 20, 80, 30, 50, 10, 20, 30, 50, 10];
$array3 = ImmutableArray::repeat(10, 5);
$array4 = [null, 10, 50, null, 100, null, 20, null, 10, 20, 200];

$arrayAssoc = [
  ['name' => 'Atlas', 'age' => '81'],
  ['name' => 'Rui', 'age' => '20'],
  ['name' => 'Kaka', 'age' => '21'],
  ['name' => 'Gildur', 'age' => '72'],
];

$comparators = [
  fn ($a, $b) => $a['age'] - $b['age'],
  fn ($a, $b) => strcmp($a['name'], $b['name'])
];

$array = ImmutableArray::of($array)
  ->flatten()
  ->filterNotNull()
  ->ifEmpty([1, 2, 3])
  ->distinct()
  ->append(1000)
  ->dropLast(1);

print_r($array);
