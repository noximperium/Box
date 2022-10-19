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

  $sut = $fun->containsKey('inventory-1', $list);

  expect($sut)->toBe($expected);
});

test('asserts containsValue behaves correctly', function () {
  $fun = new MapFunction();
  $list = [
    'inventory-1' => 'Rock',
    'inventory-2' => 'Mythril',
    'inventory-3' => 'Orichalcum',
    'inventory-4' => null,
  ];

  $expected = true;

  $sut = $fun->containsValue('Mythril', $list);

  expect($sut)->toBe($expected);
});

test('asserts containsPath behaves correctly', function () {
  $fun = new MapFunction();
  $list = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ];

  $expected = true;

  $sut = $fun->containsPath('contact.line', $list);
  expect($sut)->toBe($expected);
});

test('asserts keys behaves correctly', function () {
  $fun = new MapFunction();
  $list = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ];

  $expected = ['name', 'age', 'contact'];

  $sut = $fun->keys($list);
  expect($sut)->toBe($expected);
});

test('asserts mergeLeft behaves correctly', function () {
  $fun = new MapFunction();
  $list = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ];

  $other = [
    'age' => '85',
    'addr' => '-',
    'contact' => [
      'wa' => '04990198',
      'askfm' => '@atlas'
    ],
  ];

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

  $sut = $fun->mergeLeft($list, $other);
  expect($sut)->toBe($expected);
});

test('asserts mergeDeepLeft behaves correctly', function () {
  $fun = new MapFunction();
  $list = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ];

  $other = [
    'age' => '85',
    'addr' => '-',
    'contact' => [
      'wa' => '04990198',
      'askfm' => '@atlas'
    ],
  ];

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

  $sut = $fun->mergeDeepLeft($list, $other);
  expect($sut)->toBe($expected);
});

test('asserts mergeRight behaves correctly', function () {
  $fun = new MapFunction();
  $list = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ];

  $other = [
    'age' => '85',
    'addr' => '-',
    'contact' => [
      'wa' => '04990198',
      'askfm' => '@atlas'
    ],
  ];

  $expected = [
    'name' => 'Atlas',
    'age' => '85',
    'contact' => [
      'wa' => '04990198',
      'askfm' => '@atlas'
    ],
    'addr' => '-',
  ];

  $sut = $fun->mergeRight($list, $other);
  expect($sut)->toBe($expected);
});

test('asserts mergeDeepRight behaves correctly', function () {
  $fun = new MapFunction();
  $list = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ];

  $other = [
    'age' => '85',
    'addr' => '-',
    'contact' => [
      'wa' => '04990198',
      'askfm' => '@atlas'
    ],
  ];

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

  $sut = $fun->mergeDeepRight($list, $other);
  expect($sut)->toBe($expected);
});

test('asserts mergeWith behaves correctly', function () {
});

test('asserts mergeDeepWith behaves correctly', function () {
});

test('asserts modify behaves correctly', function () {
  $fun = new MapFunction();
  $list = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ];

  $expected = [
    'name' => 'ATLAS',
    'age' => '81',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ];

  $sut = $fun->modify('name', function ($value) {
    return strtoupper($value);
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts modifyOnPath behaves correctly', function () {
  $fun = new MapFunction();
  $list = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ];

  $expected = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ];

  $sut = $fun->modifyOnPath('contact.provider', function () {
    return 'github';
  }, $list);
  expect($sut)->toBe($expected);
});

test('asserts omit behaves correctly', function () {
  $fun = new MapFunction();
  $list = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ];

  $expected = [
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ];

  $sut = $fun->omit(['name', 'age'], $list);
  expect($sut)->toBe($expected);
});

test('asserts put behaves correctly', function () {
  $fun = new MapFunction();
  $list = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ];

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

  $sut = $fun->put('addr', '-', $list);
  expect($sut)->toBe($expected);
});

test('asserts putOnPath behaves correctly', function () {
  $fun = new MapFunction();
  $list = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas',
    ]
  ];

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

  $sut = $fun->putOnPath('contact.askfm', '@atlasian', $list);
  expect($sut)->toBe($expected);
});

test('asserts remove behaves correctly', function () {
  $fun = new MapFunction();
  $list = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas',
    ]
  ];

  $expected = [
    'name' => 'Atlas',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas',
    ]
  ];

  $sut = $fun->remove('age', $list);
  expect($sut)->toBe($expected);
});

test('asserts removeOnPath behaves correctly', function () {
  $fun = new MapFunction();
  $list = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
      'line' => '@atlas',
    ]
  ];

  $expected = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'gitlab',
      'wa' => '08423848327432',
    ]
  ];

  $sut = $fun->removeOnPath('contact.line', $list);
  expect($sut)->toBe($expected);
});

test('asserts values behaves correctly', function () {
  $fun = new MapFunction();
  $list = [
    'name' => 'Atlas',
    'age' => '81',
    'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ];

  $expected = [
    'Atlas',
    '81',
    [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]
  ];

  $sut = $fun->values($list);
  expect($sut)->toBe($expected);
});
