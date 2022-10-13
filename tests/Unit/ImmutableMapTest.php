<?php

use NoxImperium\Container\ImmutableMap;

test('asserts instance of ImmutableMap', function () {
  $container = ImmutableMap::of([]);
  $type = get_class($container);

  expect($type)->toBe('NoxImperium\\Container\\ImmutableMap');
});

test('asserts initial content of ImmutableMap is empty', function () {
  $container = ImmutableMap::of([]);
  $val = $container->val();
  $length = count($val);

  expect($length)->toBe(0);
});

test('asserts assoc behaves correctly', function () {
  $container = ImmutableMap::of([]);

  $sutOne = $container
    ->assoc('name', 'Kaka')
    ->val();

  expect($sutOne)->toBe([
    'name' => 'Kaka'
  ]);

  $sutTwo = $container
    ->assoc('name', 'Kaka')
    ->assoc('name', 'Rui')
    ->val();

  expect($sutTwo)->toBe([
    'name' => 'Rui'
  ]);
});

test('asserts assocPath behaves correctly', function () {
  $container = ImmutableMap::of([]);

  $sutOne = $container
    ->assocPath(['persons', 'kaka', 'full_name'], 'Kharisma Sri Wibowo')
    ->val();

  expect($sutOne)->toBe([
    'persons' => [
      'kaka' => [
        'full_name' => 'Kharisma Sri Wibowo'
      ]
    ]
  ]);

  $sutTwo = $container
    ->assocPath(['persons', 'kaka', 'full_name'], 'Kharisma Sri Wibowo')
    ->assocPath(['persons', 'kaka', 'age'], 21)
    ->val();

  expect($sutTwo)->toBe([
    'persons' => [
      'kaka' => [
        'full_name' => 'Kharisma Sri Wibowo',
        'age' => 21
      ]
    ]
  ]);

  $sutThree = $container
    ->assocPath(['persons', 'kaka', 'full_name'], 'Kharisma Sri Wibowo')
    ->assocPath(['persons', 'kaka', 'full_name'], 'Kharisma Sri Wibowo')
    ->assocPath(['persons', 'kaka', 'age'], 21)
    ->assocPath(['persons', 'kaka', 'age'], ['2001' => 0, '2022' => 21])
    ->val();

  expect($sutThree)->toBe([
    'persons' => [
      'kaka' => [
        'full_name' => 'Kharisma Sri Wibowo',
        'age' => [
          '2001' => 0,
          '2022' => 21
        ]
      ]
    ]
  ]);

  $sutFour = $container
    ->assocPath('persons.kaka.full_name', 'Kharisma Sri Wibowo')
    ->assocPath('persons.kaka.full_name', 'Kharisma Sri Wibowo')
    ->assocPath('persons.kaka.age', 21)
    ->assocPath('persons.kaka.age', ['2001' => 0, '2022' => 21])
    ->val();

  expect($sutFour)->toBe([
    'persons' => [
      'kaka' => [
        'full_name' => 'Kharisma Sri Wibowo',
        'age' => [
          '2001' => 0,
          '2022' => 21
        ]
      ]
    ]
  ]);
});

test('asserts dissoc behaves correctly', function () {
  $container = ImmutableMap::of([
    'name' => 'Kaka',
    'age' => 21
  ]);

  $sut = $container
    ->dissoc('name')
    ->val();

  expect($sut)->toBe([
    'age' => 21
  ]);
});

test('asserts dissocPath behaves correctly', function () {
  $container = ImmutableMap::of([
    'persons' => [
      'kaka' => [
        'full_name' => 'Kharisma Sri Wibowo',
        'age' => [
          '2001' => 0,
          '2022' => 21
        ]
      ],
      'rui' => [
        'full_name' => 'Rui',
        'age' => [
          '2005' => 0,
          '2018' => 17
        ]
      ]
    ]
  ]);

  $sutOne = $container
    ->dissocPath('persons')
    ->val();

  expect($sutOne)->toBe([]);

  $sutTwo = $container
    ->dissocPath('persons.kaka')
    ->val();

  expect($sutTwo)->toBe([
    'persons' => [
      'rui' => [
        'full_name' => 'Rui',
        'age' => [
          '2005' => 0,
          '2018' => 17
        ]
      ]
    ]
  ]);

  $sutThree = $container
    ->dissocPath('persons.kaka.age.2001')
    ->val();

  expect($sutThree)->toBe([
    'persons' => [
      'kaka' => [
        'full_name' => 'Kharisma Sri Wibowo',
        'age' => [
          '2022' => 21
        ]
      ],
      'rui' => [
        'full_name' => 'Rui',
        'age' => [
          '2005' => 0,
          '2018' => 17
        ]
      ]
    ]
  ]);
});
