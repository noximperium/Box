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

test('asserts has behaves correctly', function () {
  $container = ImmutableMap::of([
    'name' => 'Kaka',
    'age' => 21
  ]);

  $sut = $container->has('name');
  expect($sut)->toBe(true);
});

test('asserts hasPath behaves correctly', function () {
  $container = ImmutableMap::of([
    'name' => 'Kaka',
    'age' => 21,
    'account' => [
      'email' => 'gmail',
      'vcs' => 'github'
    ]
  ]);

  $sutOne = $container->hasPath('account.email');
  expect($sutOne)->toBe(true);

  $sutTwo = $container->hasPath('account.communication');
  expect($sutTwo)->toBe(false);
});

test('asserts modify behaves correctly', function () {
  $container = ImmutableMap::of([
    'name' => 'Kaka',
    'age' => 21
  ]);

  $sutOne = $container->modify('name', function ($value) {
    return strtoupper($value);
  })->val();

  expect($sutOne)->toBe([
    'name' => 'KAKA',
    'age' => 21
  ]);

  $sutTwo = $container->modify('alias', function ($value) {
    return strtoupper($value);
  })->val();

  expect($sutTwo)->toBe([
    'name' => 'Kaka',
    'age' => 21
  ]);
});

test('asserts modifyPath behaves correctly', function () {
  $container = ImmutableMap::of([
    'name' => 'Kaka',
    'age' => 21,
    'account' => [
      'email' => 'gmail',
      'vcs' => 'github'
    ]
  ]);

  $sutOne = $container->modifyPath('account.email', function ($value) {
    return strtoupper($value);
  })->val();

  expect($sutOne)->toBe([
    'name' => 'Kaka',
    'age' => 21,
    'account' => [
      'email' => 'GMAIL',
      'vcs' => 'github'
    ]
  ]);

  $sutTwo = $container->modify('account.note', function ($value) {
    return strtoupper($value);
  })->val();

  expect($sutTwo)->toBe([
    'name' => 'Kaka',
    'age' => 21,
    'account' => [
      'email' => 'gmail',
      'vcs' => 'github'
    ]
  ]);
});

test('asserts omit behaves correctly', function () {
  $container = ImmutableMap::of([
    'name' => 'Kaka',
    'age' => 21,
    'account' => [
      'email' => 'gmail',
      'vcs' => 'github'
    ]
  ]);

  $sut = $container->omit(['age', 'account'])->val();

  expect($sut)->toBe([
    'name' => 'Kaka',
  ]);
});

test('asserts path behaves correctly', function () {
  $container = ImmutableMap::of([
    'name' => 'Kaka',
    'age' => 21
  ]);

  $sutOne = $container->path('name');
  expect($sutOne)->toBe('Kaka');

  $sutTwo = $container
    ->assoc('account', [
      'email' => 'gmail',
      'vcs' => 'github'
    ])
    ->path('account');

  expect($sutTwo)->toBe([
    'email' => 'gmail',
    'vcs' => 'github'
  ]);

  $sutThree = $container
    ->assoc('account', [
      'email' => 'gmail',
      'vcs' => 'github'
    ])
    ->path('account.email');

  expect($sutThree)->toBe('gmail');
});

test('asserts pathEq behaves correctly', function () {
  $container = ImmutableMap::of([
    'name' => 'Kaka',
    'age' => 21,
    'account' => [
      'email' => 'gmail',
      'vcs' => 'github'
    ]
  ]);

  $sutOne = $container->pathEq('name', 'Kaka');
  expect($sutOne)->toBe(true);

  $sutTwo = $container->pathEq('account.email', 'yahoo');
  expect($sutTwo)->toBe(false);
});

test('asserts pathOr behaves correctly', function () {
  $container = ImmutableMap::of([
    'name' => 'Kaka',
    'age' => 21,
    'account' => [
      'email' => 'gmail',
      'vcs' => 'github'
    ]
  ]);

  $sutOne = $container->pathOr('verified', true);
  expect($sutOne)->toBe(true);

  $sutTwo = $container->pathOr('name', 'No Name');
  expect($sutTwo)->toBe('Kaka');
});
