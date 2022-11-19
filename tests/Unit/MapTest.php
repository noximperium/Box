<?php

use NoxImperium\Box\Box;

test('asserts containsKey behaves correctly', function () {
  $map = Box::ofMap([
    'inventory-1' => 'Rock',
    'inventory-2' => 'Mythril',
    'inventory-3' => 'Orichalcum',
    'inventory-4' => null,
  ]);

  $expected = true;

  $sut = $map->containsKey('inventory-1');

  expect($sut)->toBe($expected);
});

test('asserts containsValue behaves correctly', function () {
  $map = Box::ofMap([
    'inventory-1' => 'Rock',
    'inventory-2' => 'Mythril',
    'inventory-3' => 'Orichalcum',
    'inventory-4' => null,
  ]);

  $sut = $map->containsValue('Mythril');

  $expected = true;

  expect($sut)->toBe($expected);
});

test('asserts containsPath behaves correctly', function () {
  $map = Box::ofMap([
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ]);

  $sut = $map->containsPath('contact.line');

  $expected = true;

  expect($sut)->toBe($expected);
});

test('asserts keys behaves correctly', function () {
  $map = Box::ofMap([
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ]);

  $sut = $map->keys()->val();

  $expected = ['name', 'age', 'contact'];

  expect($sut)->toBe($expected);
});

test('asserts mergeLeft behaves correctly', function () {
  $map = Box::ofMap([
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ]);

  $other = [
    'age' => '85',
    'addr' => '-',
    'contact' => [
      'wa' => '04990198',
      'askfm' => '@atlas'
    ],
  ];

  $sut = $map->mergeLeft($other)->val();

  $expected = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas',
    ],
    'addr' => '-',
  ];

  expect($sut)->toBe($expected);
});

test('asserts mergeDeepLeft behaves correctly', function () {
  $map = Box::ofMap([
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ]);

  $other = [
    'age' => '85',
    'addr' => '-',
    'contact' => [
      'wa' => '04990198',
      'askfm' => '@atlas'
    ],
  ];

  $sut = $map->mergeDeepLeft($other)->val();

  $expected = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas',
      'askfm' => '@atlas'
    ],
    'addr' => '-',
  ];

  expect($sut)->toBe($expected);
});

test('asserts mergeRight behaves correctly', function () {
  $map = Box::ofMap([
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ]);

  $other = [
    'age' => '85',
    'addr' => '-',
    'contact' => [
      'wa' => '04990198',
      'askfm' => '@atlas'
    ],
  ];

  $sut = $map->mergeRight($other)->val();

  $expected = [
    'name' => 'Atlas',
    'age' => '85',
    'contact' => [
      'wa' => '04990198',
      'askfm' => '@atlas'
    ],
    'addr' => '-',
  ];

  expect($sut)->toBe($expected);
});

test('asserts mergeDeepRight behaves correctly', function () {
  $map = Box::ofMap([
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ]);

  $other = [
    'age' => '85',
    'addr' => '-',
    'contact' => [
      'wa' => '04990198',
      'askfm' => '@atlas'
    ],
  ];

  $sut = $map->mergeDeepRight($other)->val();

  $expected = [
    'name' => 'Atlas',
    'age' => '85',
    'contact' => [
      'provider' => 'github',
      'wa' => '04990198',
      'line' => '@atlas',
      'askfm' => '@atlas'
    ],
    'addr' => '-',
  ];

  expect($sut)->toBe($expected);
});

test('asserts mergeWith behaves correctly', function () {
  $map = Box::ofMap([
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ]);

  $other = [
    'age' => '85',
  ];

  $sut = $map->mergeWith(function ($a, $b) {
    return "$a $b";
  }, $other)->val();

  $expected = [
    'name' => 'Atlas',
    'age' => '81 85',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ];

  expect($sut)->toBe($expected);
});

test('asserts mergeDeepWith behaves correctly', function () {
  $map = Box::ofMap([
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ]);

  $other = [
    'age' => '85',
    'contact' => [
      'askfm' => '@atlas'
    ],
  ];

  $sut = $map->mergeDeepWith(function ($a, $b) {
    return "$a $b";
  }, $other)->val();

  $expected = [
    'name' => 'Atlas',
    'age' => '81 85',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas',
      'askfm' => '@atlas'
    ]
  ];

  expect($sut)->toBe($expected);
});

test('asserts modify behaves correctly', function () {
  $map = Box::ofMap([
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ]);

  $sut = $map->modify('name', function ($value) {
    return strtoupper($value);
  })->val();

  $expected = [
    'name' => 'ATLAS',
    'age' => '81',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ];

  expect($sut)->toBe($expected);
});

test('asserts modifyOnPath behaves correctly', function () {
  $map = Box::ofMap([
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ]);

  $sut = $map->modifyOnPath('contact.provider', function () {
    return 'github';
  })->val();

  $expected = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ];

  expect($sut)->toBe($expected);
});

test('asserts omit behaves correctly', function () {
  $map = Box::ofMap([
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ]);

  $sut = $map->omit(['name', 'age'])->val();

  $expected = [
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ];

  expect($sut)->toBe($expected);
});

test('asserts put behaves correctly', function () {
  $map = Box::ofMap([
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ]);

  $sut = $map->put('addr', '-')->val();

  $expected = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ],
    'addr' => '-',
  ];

  expect($sut)->toBe($expected);
});

test('asserts putOnPath behaves correctly', function () {
  $map = Box::ofMap([
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas',
    ]
  ]);

  $sut = $map->putOnPath('contact.askfm', '@atlasian')->val();

  $expected = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas',
      'askfm' => '@atlasian'
    ]
  ];

  expect($sut)->toBe($expected);
});

test('asserts remove behaves correctly', function () {
  $map = Box::ofMap([
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas',
    ]
  ]);

  $sut = $map->remove('age')->val();

  $expected = [
    'name' => 'Atlas',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas',
    ]
  ];

  expect($sut)->toBe($expected);
});

test('asserts removeOnPath behaves correctly', function () {
  $map = Box::ofMap([
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas',
    ]
  ]);

  $sut = $map->removeOnPath('contact.line')->val();

  $expected = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
    ]
  ];

  expect($sut)->toBe($expected);
});

test('asserts values behaves correctly', function () {
  $map = Box::ofMap([
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ]);

  $sut = $map->values()->val();

  $expected = [
    'Atlas',
    '81',
    [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ];

  expect($sut)->toBe($expected);
});
