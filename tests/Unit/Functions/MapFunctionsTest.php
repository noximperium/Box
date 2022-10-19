<?php

use NoxImperium\Box\Functions\MapFunction;

test('asserts all behaves correctly', function () {
  $fun = new MapFunction();
  $list = [
    'inventory-1' => 'Rock',
    'inventory-2' => 'Mythril',
    'inventory-3' => 'Orichalcum',
    'inventory-4' => null,
  ];

  $expected = false;

  $sut = $fun->all(function ($value) {
    return $value !== null;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts any behaves correctly', function () {
  $fun = new MapFunction();
  $list = [
    'inventory-1' => 'Rock',
    'inventory-2' => 'Mythril',
    'inventory-3' => 'Orichalcum',
    'inventory-4' => null,
  ];

  $expected = true;

  $sut = $fun->any(function ($value) {
    return $value !== null;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts containsKey behaves correctly', function () {
  $fun = new MapFunction();
  $list = [
    'inventory-1' => 'Rock',
    'inventory-2' => 'Mythril',
    'inventory-3' => 'Orichalcum',
    'inventory-4' => null,
  ];

  $expected = true;

  $sut = $fun->containsKey(function ($key) {
    return $key === 'inventory-1';
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts assoc behaves correctly', function () {
  $container = ImmutableAssoc::of([]);

  $sutOne = $container
    ->put('name', 'Kaka')
    ->val();

  expect($sutOne)->toBe([
    'name' => 'Kaka'
  ]);

  $sutTwo = $container
    ->put('name', 'Kaka')
    ->put('name', 'Rui')
    ->val();

  expect($sutTwo)->toBe([
    'name' => 'Rui'
  ]);
});

test('asserts assocPath behaves correctly', function () {
  $container = ImmutableAssoc::of([]);

  $sutOne = $container
    ->putPath(['persons', 'kaka', 'full_name'], 'Kharisma Sri Wibowo')
    ->val();

  expect($sutOne)->toBe([
    'persons' => [
      'kaka' => [
        'full_name' => 'Kharisma Sri Wibowo'
      ]
    ]
  ]);

  $sutTwo = $container
    ->putPath(['persons', 'kaka', 'full_name'], 'Kharisma Sri Wibowo')
    ->putPath(['persons', 'kaka', 'age'], 21)
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
    ->putPath(['persons', 'kaka', 'full_name'], 'Kharisma Sri Wibowo')
    ->putPath(['persons', 'kaka', 'full_name'], 'Kharisma Sri Wibowo')
    ->putPath(['persons', 'kaka', 'age'], 21)
    ->putPath(['persons', 'kaka', 'age'], ['2001' => 0, '2022' => 21])
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
    ->putPath('persons.kaka.full_name', 'Kharisma Sri Wibowo')
    ->putPath('persons.kaka.full_name', 'Kharisma Sri Wibowo')
    ->putPath('persons.kaka.age', 21)
    ->putPath('persons.kaka.age', ['2001' => 0, '2022' => 21])
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
  $container = ImmutableAssoc::of([
    'name' => 'Kaka',
    'age' => 21
  ]);

  $sut = $container
    ->remove('name')
    ->val();

  expect($sut)->toBe([
    'age' => 21
  ]);
});

test('asserts dissocPath behaves correctly', function () {
  $container = ImmutableAssoc::of([
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
    ->removePath('persons')
    ->val();

  expect($sutOne)->toBe([]);

  $sutTwo = $container
    ->removePath('persons.kaka')
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
    ->removePath('persons.kaka.age.2001')
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
  $container = ImmutableAssoc::of([
    'name' => 'Kaka',
    'age' => 21
  ]);

  $sut = $container->has('name');
  expect($sut)->toBe(true);
});

test('asserts hasPath behaves correctly', function () {
  $container = ImmutableAssoc::of([
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
  $container = ImmutableAssoc::of([
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
  $container = ImmutableAssoc::of([
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
  $container = ImmutableAssoc::of([
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
  $container = ImmutableAssoc::of([
    'name' => 'Kaka',
    'age' => 21
  ]);

  $sutOne = $container->path('name');
  expect($sutOne)->toBe('Kaka');

  $sutTwo = $container
    ->put('account', [
      'email' => 'gmail',
      'vcs' => 'github'
    ])
    ->path('account');

  expect($sutTwo)->toBe([
    'email' => 'gmail',
    'vcs' => 'github'
  ]);

  $sutThree = $container
    ->put('account', [
      'email' => 'gmail',
      'vcs' => 'github'
    ])
    ->path('account.email');

  expect($sutThree)->toBe('gmail');
});

test('asserts pathEq behaves correctly', function () {
  $container = ImmutableAssoc::of([
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
  $container = ImmutableAssoc::of([
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
