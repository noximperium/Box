<?php

use NoxImperium\Box\Functions\ListFunction;

test('asserts all behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];

  $sut = $fun->all(function ($value) {
    return $value > 0;
  }, $list);

  expect($sut)->toBe(true);
});

test('asserts any behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];

  $sut = $fun->any(function ($value) {
    return $value % 2 === 0;
  }, $list);

  expect($sut)->toBe(true);
});

test('asserts adjust behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];

  $sut = $fun->adjust(1, function ($val) {
    return $val + 20;
  }, $list);

  expect($sut)->toBe([1, 22, 3]);
});

test('asserts append behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];

  $sut = $fun->append(20, $list);
  expect($sut)->toBe([1, 2, 3, 20]);
});

test('asserts appendAll behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];

  $sut = $fun->appendAll([20, 30, 40], $list);
  expect($sut)->toBe([1, 2, 3, 20, 30, 40]);
});

test('asserts average behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];

  $sut = $fun->average($list);
  expect($sut)->toBe(2);
});

test('asserts contains behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];

  $sutOne = $fun->contains(1, $list);
  expect($sutOne)->toBe(true);

  $sutTwo = $fun->contains(10, $list);
  expect($sutTwo)->toBe(false);
});

test('asserts containsAll behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];

  $sutOne = $fun->containsAll([1, 2], $list);
  expect($sutOne)->toBe(true);

  $sutTwo = $fun->containsAll([1, 2, 10], $list);
  expect($sutTwo)->toBe(false);
});


test('asserts collectBy behaves correctly', function () {
  $fun = new ListFunction();
  $list = [
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Kaka', 'title' => 'Grand Master'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
  ];

  $expected = [
    [
      ['name' => 'Kaka', 'title' => 'Pro']
    ],
    [
      ['name' => 'Kaka', 'title' => 'Grand Master'],
      ['name' => 'Rui', 'title' => 'Grand Master'],
    ],
    [
      ['name' => 'Alex', 'title' => 'Grandeur']
    ]
  ];


  $sut = $fun->collectBy(function ($element) {
    return $element['title'];
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts count behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 1, 2, 2, 3, 4, 5, 5, 3, 4, 4, 1, 2, 1, 1];
  $expected = 3;

  $sut = $fun->count(function ($element) {
    return $element === 2;
  }, $list);

  expect($sut)->toBe($expected);
});


test('asserts distinct behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 1, 2, 2, 3, 4, 5, 5, 3, 4, 4, 1, 2, 1, 1];
  $expected = [1, 2, 3, 4, 5];

  $sut = $fun->distinct($list);
  expect($sut)->toBe($expected);
});

test('asserts distinctBy behaves correctly', function () {
  $fun = new ListFunction();
  $list = [
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Kaka', 'title' => 'Grand Master'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
  ];

  $expected = [
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Kaka', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
  ];

  $sut = $fun->distinctBy(function ($element) {
    return $element['title'];
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts drop behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];

  $sut = $fun->drop(1, $list);

  expect($sut)->toBe([2, 3]);
});

test('asserts dropWhile behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3, 4, 5, 6, 7];

  $sut = $fun->dropWhile(function ($element) {
    return  $element !== 3;
  }, $list);

  expect($sut)->toBe([3, 4, 5, 6, 7]);
});

test('asserts dropLast behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];

  $sut = $fun->dropLast(1, $list);
  expect($sut)->toBe([1, 2]);
});

test('asserts dropLastWhile behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3, 4, 5, 6, 7];

  $sut = $fun->dropLastWhile(function ($element) {
    return $element !== 3;
  }, $list);

  expect($sut)->toBe([1, 2]);
});

test('asserts dropRepeats behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 2, 1, 3, 3, 3];

  $sut = $fun->dropRepeats($list);
  expect($sut)->toBe([1, 2, 1, 3]);
});

test('asserts dropRepeatsBy behaves correctly', function () {
  $fun = new ListFunction();
  $list = [
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Kaka', 'title' => 'Grand Master'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
  ];

  $expected = [
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
  ];

  $sut = $fun->dropRepeatsBy(function ($a, $b) {
    return $a['name'] !== $b['name'];
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts endsWith behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3, 4, 5, 6];
  $expected = true;

  $sut = $fun->endsWith([4, 5, 6], $list);
  expect($sut)->toBe($expected);
});

test('asserts filter behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3, 4, 5, 6];

  $expectedEven = [2, 4, 6];
  $expectedOdd = [1, 3, 5];

  $sutEven = $fun->filter(function ($val) {
    return $val % 2 === 0;
  }, $list);

  expect($sutEven)->toBe($expectedEven);

  $sutOdd = $fun->filter(function ($val) {
    return $val % 2 !== 0;
  }, $list);

  expect($sutOdd)->toBe($expectedOdd);
});

test('asserts filterIndexed behaves correctly', function () {
  $fun = new ListFunction();
  $list = [0, 1, 2, 3, 3, 4, 5];
  $expected = [0, 1, 2, 3];

  $sut = $fun->filterIndexed(function ($idx, $val) {
    return $idx === $val;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts filterNot behaves correctly', function () {
  $fun = new ListFunction();
  $list = [
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
    ['name' => 'Tulen', 'title' => 'Pro'],
    ['name' => 'Ilumia', 'title' => 'Grandeur'],
  ];

  $expected = [
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Tulen', 'title' => 'Pro'],
  ];

  $sut = $fun->filterNot(function ($val) {
    return $val['title'] === 'Grandeur';
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts filterNotIndexed behaves correctly', function () {
  $fun = new ListFunction();
  $list = [
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
    ['name' => 'Tulen', 'title' => 'Pro'],
    ['name' => 'Ilumia', 'title' => 'Grandeur'],
  ];

  $expected = [
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
  ];

  $sut = $fun->filterNotIndexed(function ($index, $value) {
    return $index > 2;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts filterNotNull behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 5, null, 0, null, 2, 3, null];
  $expected = [1, 5, 0, 2, 3];

  $sut = $fun->filterNotNull($list);
  expect($sut)->toBe($expected);
});

test('asserts find behaves correctly', function () {
  $fun = new ListFunction();
  $list = [
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
    ['name' => 'Tulen', 'title' => 'Pro'],
    ['name' => 'Ilumia', 'title' => 'Grandeur'],
  ];

  $expected = ['name' => 'Alex', 'title' => 'Grandeur'];

  $sut = $fun->find(function ($val) {
    return $val['title'] === 'Grandeur';
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts findLast behaves correctly', function () {
  $fun = new ListFunction();
  $list = [
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
    ['name' => 'Tulen', 'title' => 'Pro'],
    ['name' => 'Ilumia', 'title' => 'Grandeur'],
  ];

  $expected = ['name' => 'Ilumia', 'title' => 'Grandeur'];

  $sut = $fun->findLast(function ($val) {
    return $val['title'] === 'Grandeur';
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts findIndex behaves correctly', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30];
  $expected = 0;

  $sut = $fun->findIndex(10, $list);
  expect($sut)->toBe($expected);
});

test('asserts findLastIndex behaves correctly', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30, 20, 10];
  $expected = 3;

  $sut = $fun->findLastIndex(20, $list);
  expect($sut)->toBe($expected);
});


test('asserts first on non-empty array', function () {
  $fun = new ListFunction();
  $list = [
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
  ];

  $expected = ['name' => 'Kaka', 'title' => 'Pro'];

  $sut = $fun->first($list);
  expect($sut)->toBe($expected);
});

test('asserts first on empty array', function () {
  $fun = new ListFunction();
  $list = [];

  $fun->first($list);
})->throws(Exception::class, 'The List is empty.');

test('asserts firstOrNull on non-empty array', function () {
  $fun = new ListFunction();
  $list = [
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
  ];

  $expected = ['name' => 'Kaka', 'title' => 'Pro'];

  $sut = $fun->firstOrNull($list);
  expect($sut)->toBe($expected);
});

test('asserts firstOrNull on empty array', function () {
  $fun = new ListFunction();
  $list = [];
  $expected = null;

  $sut = $fun->firstOrNull($list);
  expect($sut)->toBe($expected);
});

test('asserts flatMap behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];
  $expected = [1, 2, 3, 2, 3, 4, 3, 4, 5];

  $sut = $fun->flatMap(function ($val) {
    return [$val, $val + 1, $val + 2];
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts flatMapIndexed behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];
  $expected = ['0 1', '1 0', '1 2', '2 1', '2 3', '3 2'];

  $sut = $fun->flatMapIndexed(function ($key, $val) {
    return  ["$key $val", "$val $key"];
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts flatten behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, [2, 3, [4], [5, 6, 7, [8]], [9]]];
  $expected = [1, 2, 3, 4, 5, 6, 7, 8, 9];

  $sut = $fun->flatten($list);

  expect($sut)->toBe($expected);
});

test('asserts fold behaves correctly', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30];
  $expected = 160;

  $sut = $fun->fold(100, function ($acc, $cur) {
    return $acc + $cur;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts foldIndexed behaves correctly', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30];
  $expected = 163;

  $sut = $fun->foldIndexed(100, function ($idx, $acc, $cur) {
    return $idx + $acc + $cur;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts foldRight behaves correctly', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30];
  $expected = -10;

  $sut = $fun->fold(50, function ($acc, $cur) {
    return $acc - $cur;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts foldRightIndexed behaves correctly', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30];
  $expected = -13;

  $sut = $fun->foldIndexed(50, function ($acc, $idx, $cur) {
    return $acc - $cur - $idx;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts forEach behaves correctly', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30];
  $expected = [10, 20, 30];

  $sut = [];
  $fun->forEach(function ($value) use (&$sut) {
    $sut[] = $value;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts forEachIndexed behaves correctly', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30];
  $expected = [
    "Index: 0 | Value: 10",
    "Index: 1 | Value: 20",
    "Index: 2 | Value: 30"
  ];

  $sut = [];
  $fun->forEachIndexed(function ($idx, $val) use (&$sut) {
    $sut[] = "Index: $idx | Value: $val";
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts get on existing index', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30];
  $expected = 10;

  $sut = $fun->get(0, $list);
  expect($sut)->toBe($expected);
});

test('asserts get on non-existing index', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30];
  $fun->get(10, $list);
})->throws(Exception::class);

test('asserts getOrElse on existing index', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30];
  $expected = 10;

  $sut = $fun->getOrElse(0, 'Not found', $list);
  expect($sut)->toBe(10);
});

test('asserts getOrElse on non-existing index', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30];
  $expected = 'Not found';

  $sut = $fun->getOrElse(10, 'Not found', $list);
  expect($sut)->toBe($expected);
});

test('asserts getOrNull on existing index', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30];
  $expected = 10;

  $sut = $fun->getOrNull(0, $list);
  expect($sut)->toBe($expected);
});

test('asserts getOrNull on non-existing index', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30];
  $expected = null;

  $sut = $fun->getOrNull(10, $list);
  expect($sut)->toBe($expected);
});

test('asserts getOnPath on existing index', function () {
  $fun = new ListFunction();
  $list = [
    [
      'name' => 'Kaka',
      'age' => '21',
    ],
    [
      'name' => 'Enzo',
      'age' => '24',
    ]
  ];

  $sut = $fun->getOnPath('1.name', $list);
  expect($sut)->toBe('Enzo');
});

test('asserts getOnPath on non-existing index', function () {
  $fun = new ListFunction();
  $list = [
    [
      'name' => 'Kaka',
      'age' => '21',
    ],
    [
      'name' => 'Enzo',
      'age' => '24',
    ]
  ];
  $fun->getOnPath('0.address', $list);
})->throws('Path not found.');

test('asserts getOnPathOrElse behaves correctly', function () {
  $fun = new ListFunction();
  $list = [
    [
      'name' => 'Kaka',
      'age' => '21',
    ],
    [
      'name' => 'Enzo',
      'age' => '24',
    ]
  ];

  $sutOne = $fun->getOnPathOrElse('1.name', 'No Name', $list);
  expect($sutOne)->toBe('Enzo');

  $sutTwo = $fun->getOnPathOrElse('4.name', 'No Name', $list);
  expect($sutTwo)->toBe('No Name');
});

test('asserts getOnPathOrNull behaves correctly', function () {
  $fun = new ListFunction();
  $list = [
    [
      'name' => 'Kaka',
      'age' => '21',
    ],
    [
      'name' => 'Enzo',
      'age' => '24',
    ]
  ];

  $sutOne = $fun->getOnPathOrNull('1.name', $list);
  expect($sutOne)->toBe('Enzo');

  $sutTwo = $fun->getOnPathOrNull('4.name', $list);
  expect($sutTwo)->toBe(null);
});

test('asserts getOnPaths behaves correctly', function () {
  $fun = new ListFunction();
  $list = [
    [
      'name' => 'Kaka',
      'age' => '21',
    ],
    [
      'name' => 'Enzo',
      'age' => '24',
    ]
  ];

  $sut = $fun->getOnPaths(['0.name', '0.age', '1.name', '1.age', '2.name', '2.age'], $list);
  expect($sut)->toBe(['Kaka', '21', 'Enzo', '24', null, null]);
});

test('asserts groupBy behaves correctly', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30, 100, 120, 150];
  $expected = [
    'Tens' => [10, 20, 30],
    'Hundreds' => [100, 120, 150],
  ];

  $sut = $fun->groupBy(function ($value) {
    return $value >= 100 ? 'Hundreds' : 'Tens';
  }, null, $list);

  expect($sut)->toBe($expected);
});

// TODO
test('asserts groupByKeyed behaves correctly', function () {
});

test('asserts getOnPath behaves correctly', function () {
  $fun = new ListFunction();
  $list = [
    ['name' => 'Atlas', 'age' => '81', 'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]],
    ['name' => 'Rui', 'age' => '20', 'contact' => [
      'provider' => 'github',
      'wa' => '0985823423',
      'line' => '@rui'
    ]],
    ['name' => 'Kaka', 'age' => '21', 'contact' => [
      'provider' => 'github',
      'wa' => '08412121873',
      'line' => '@kaka'
    ]],
    ['name' => 'Gildur', 'age' => '72', 'contact' => [
      'provider' => 'gitlab',
      'wa' => '085747342121',
      'line' => '@gildur'
    ]],
  ];

  $expected = '20';

  $sut = $fun->getOnPath("1.age", $list);
  expect($sut)->toBe($expected);
});

test('asserts head behaves correctly', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30];
  $expected = 10;

  $sut = $fun->head($list);
  expect($sut)->toBe($expected);
});

test('asserts insert behaves correctly', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30];
  $expected = [10, 20, 100, 30];

  $sut = $fun->insert(2, 100, $list);
  expect($sut)->toBe($expected);
});

test('asserts insertAll with array behaves correctly', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30];
  $expected = [10, 20, 100, 200, 30];

  $sut = $fun->insertAll(2, [100, 200], $list);
  expect($sut)->toBe($expected);
});

test('asserts insertAll with single value behaves correctly', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30];
  $expected = [10, 20, 100, 30];

  $sut = $fun->insertAll(2, 100, $list);
  expect($sut)->toBe($expected);
});

test('asserts last behaves correctly', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30];
  $expected = 30;

  $sut = $fun->last($list);
  expect($sut)->toBe($expected);
});

test('asserts map behaves correctly', function () {
  $fun = new ListFunction();
  $list = ['Kaka', 'Enzo', 'Zata'];
  $expected = [
    ['name' => 'Kaka', 'age' => '-'],
    ['name' => 'Enzo', 'age' => '-'],
    ['name' => 'Zata', 'age' => '-'],
  ];

  $sut = $fun->map(function ($element) {
    return ['name' => $element, 'age' => '-'];
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts mapIndexed behaves correctly', function () {
  $fun = new ListFunction();
  $list = ['Kaka', 'Enzo', 'Zata'];
  $expected = [
    ['name' => 'Kaka', 'index' => 0, 'age' => '-'],
    ['name' => 'Enzo', 'index' => 1, 'age' => '-'],
    ['name' => 'Zata', 'index' => 2, 'age' => '-'],
  ];

  $sut = $fun->mapIndexed(function ($index, $element) {
    return ['name' => $element, 'index' => $index, 'age' => '-'];
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts mapNotNull behaves correctly', function () {
  $fun = new ListFunction();
  $list = ['Kaka', 'Enzo', 'Zata', null, 'Tulen'];
  $expected = [
    ['name' => 'Kaka', 'age' => '-'],
    ['name' => 'Enzo', 'age' => '-'],
    ['name' => 'Zata', 'age' => '-'],
    ['name' => 'Tulen', 'age' => '-'],
  ];

  $sut = $fun->mapNotNull(function ($element) {
    if ($element === null) return null;
    return ['name' => $element, 'age' => '-'];
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts mapIndexedNotNull behaves correctly', function () {
  $fun = new ListFunction();
  $list = ['Kaka', 'Enzo', 'Zata', null, 'Tulen'];
  $expected = [
    ['name' => 'Kaka', 'index' => 0, 'age' => '-'],
    ['name' => 'Enzo', 'index' => 1, 'age' => '-'],
    ['name' => 'Zata', 'index' => 2, 'age' => '-'],
    ['name' => 'Tulen', 'index' => 4, 'age' => '-'],
  ];

  $sut = $fun->mapIndexedNotNull(function ($index, $element) {
    if ($element === null) return null;
    return ['name' => $element, 'index' => $index, 'age' => '-'];
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts max behaves correctly', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30, 10, 100, 80, 20];
  $expected = 100;

  $sut = $fun->max($list);
  expect($sut)->toBe($expected);
});

test('asserts min behaves correctly', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30, 10, 100, 80, 20];
  $expected = 10;

  $sut = $fun->min($list);
  expect($sut)->toBe($expected);
});

test('asserts none behaves correctly', function () {
  $fun = new ListFunction();
  $list = [10, 20, 30];
  $expected = true;

  $sut = $fun->none(function ($element) {
    return $element > 100;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts pluck behaves correctly', function () {
  $fun = new ListFunction();
  $list = [
    ['name' => 'Atlas', 'age' => '81', 'contact' => [
      'provider' => 'github',
      'wa' => '08423848327432',
      'line' => '@atlas'
    ]],
    ['name' => 'Rui', 'age' => '20', 'contact' => [
      'provider' => 'github',
      'wa' => '0985823423',
      'line' => '@rui'
    ]],
    ['name' => 'Kaka', 'age' => '21', 'contact' => [
      'provider' => 'github',
      'wa' => '08412121873',
      'line' => '@kaka'
    ]],
    ['name' => 'Gildur', 'age' => '72', 'contact' => [
      'provider' => 'gitlab',
      'wa' => '085747342121',
      'line' => '@gildur'
    ]]
  ];

  $expected = ['@atlas', '@rui', '@kaka', '@gildur'];

  $sut = $fun->pluck('contact.line', null, $list);

  expect($sut)->toBe($expected);
});

test('asserts partition behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
  $expected = [
    [2, 4, 6, 8, 10],
    [1, 3, 5, 7, 9],
  ];

  $sut = $fun->partition(function ($element) {
    return $element % 2 === 0;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts prepend behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];
  $expected = [10, 1, 2, 3];

  $sut = $fun->prepend(10, $list);
  expect($sut)->toBe($expected);
});

test('asserts prependAll behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];
  $expected = [10, 11, 12, 1, 2, 3];

  $sut = $fun->prependAll([10, 11, 12], $list);
  expect($sut)->toBe($expected);
});

test('asserts reduce on non-empty list behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];
  $expected = 6;

  $sut = $fun->reduce(function ($accumulator, $element) {
    return $accumulator + $element;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts reduce on empty list behaves correctly', function () {
  $fun = new ListFunction();
  $list = [];

  $fun->reduce(function ($accumulator, $element) {
    return $accumulator + $element;
  }, $list);
})->throws('List is empty.');

test('asserts reduceOrNull on non-empty list behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];
  $expected = 6;

  $sut = $fun->reduceOrNull(function ($accumulator, $element) {
    return $accumulator + $element;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts reduceOrNull on empty list behaves correctly', function () {
  $fun = new ListFunction();
  $list = [];
  $expected = null;

  $sut = $fun->reduceOrNull(function ($accumulator, $element) {
    return $accumulator + $element;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts reduceIndexed on non-empty list behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];
  $expected = 9;

  $sut = $fun->reduceIndexed(function ($accumulator, $index, $element) {
    return $accumulator + $index + $element;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts reduceIndexed on empty list behaves correctly', function () {
  $fun = new ListFunction();
  $list = [];

  $fun->reduce(function ($accumulator, $index, $element) {
    return $accumulator + $index + $element;
  }, $list);
})->throws('List is empty.');

test('asserts reduceRight on non-empty list behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];
  $expected = 6;

  $sut = $fun->reduceRight(function ($accumulator, $element) {
    return $accumulator + $element;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts reduceRight on empty list behaves correctly', function () {
  $fun = new ListFunction();
  $list = [];

  $fun->reduceRight(function ($accumulator, $element) {
    return $accumulator + $element;
  }, $list);
})->throws('List is empty.');

test('asserts reduceRightOrNull on non-empty list behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];
  $expected = 6;

  $sut = $fun->reduceRightOrNull(function ($accumulator, $element) {
    return $accumulator + $element;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts reduceRightOrNull on empty list behaves correctly', function () {
  $fun = new ListFunction();
  $list = [];
  $expected = null;

  $sut = $fun->reduceRightOrNull(function ($accumulator, $element) {
    return $accumulator + $element;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts reverse behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];
  $expected = [3, 2, 1];

  $sut = $fun->reverse($list);
  expect($sut)->toBe($expected);
});

test('asserts runningFold behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];
  $expected = [0, 1, 3, 6];

  $sut = $fun->runningFold(0, function ($accumulator, $element) {
    return $accumulator + $element;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts runningFoldIndexed behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];
  $expected = [0, 1, 4, 9];

  $sut = $fun->runningFoldIndexed(0, function ($accumulator, $index, $element) {
    return $accumulator + $index + $element;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts runningFoldRight behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];
  $expected = [0, 3, 5, 6];

  $sut = $fun->runningFoldRight(0, function ($accumulator, $element) {
    return $accumulator + $element;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts runningFoldRightIndexed behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];
  $expected = [0, 5, 8, 9];

  $sut = $fun->runningFoldRightIndexed(0, function ($accumulator, $index, $element) {
    return $accumulator + $index + $element;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts runningReduce behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];
  $expected = [1, 3, 6];

  $sut = $fun->runningReduce(function ($accumulator, $element) {
    return $accumulator + $element;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts runningReduceIndexed behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];
  $expected = [1, 4, 9];

  $sut = $fun->runningReduceIndexed(function ($accumulator, $index, $element) {
    return $accumulator + $index + $element;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts runningReduceRight behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];
  $expected = [3, 5, 6];

  $sut = $fun->runningReduceRight(function ($accumulator, $element) {
    return $accumulator + $element;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts runningReduceRightIndexed behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];
  $expected = [3, 6, 7];

  $sut = $fun->runningReduceRightIndexed(function ($accumulator, $index, $element) {
    return $accumulator + $index + $element;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts sum behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3];
  $expected = 6;

  $sut = $fun->sum($list);
  expect($sut)->toBe($expected);
});

test('asserts startsWith behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3, 4, 5, 6];
  $expected = true;

  $sut = $fun->startsWith([1, 2, 3], $list);
  expect($sut)->toBe($expected);
});

test('asserts slice behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3, 4, 5, 6];
  $expected = [2, 3];

  $sut = $fun->slice(1, 3, $list);
  expect($sut)->toBe($expected);
});

test('asserts sortBy behaves correctly', function () {
  $fun = new ListFunction();
  $list = [
    ['name' => 'Orichalcum', 'rarity' => 3],
    ['name' => 'Mythril', 'rarity' => 5],
    ['name' => 'Gold', 'rarity' => 4],
    ['name' => 'Silver', 'rarity' => 2],
    ['name' => 'Bronze', 'rarity' => 1],
  ];

  $expected = [
    ['name' => 'Bronze', 'rarity' => 1],
    ['name' => 'Silver', 'rarity' => 2],
    ['name' => 'Orichalcum', 'rarity' => 3],
    ['name' => 'Gold', 'rarity' => 4],
    ['name' => 'Mythril', 'rarity' => 5],
  ];

  $sut = $fun->sortBy(function ($element) {
    return $element['rarity'];
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts sortByDescending behaves correctly', function () {
  $fun = new ListFunction();
  $list = [
    ['name' => 'Orichalcum', 'rarity' => 3],
    ['name' => 'Mythril', 'rarity' => 5],
    ['name' => 'Gold', 'rarity' => 4],
    ['name' => 'Silver', 'rarity' => 2],
    ['name' => 'Bronze', 'rarity' => 1],
  ];

  $expected = [
    ['name' => 'Mythril', 'rarity' => 5],
    ['name' => 'Gold', 'rarity' => 4],
    ['name' => 'Orichalcum', 'rarity' => 3],
    ['name' => 'Silver', 'rarity' => 2],
    ['name' => 'Bronze', 'rarity' => 1],
  ];

  $sut = $fun->sortByDescending(function ($element) {
    return $element['rarity'];
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts splitAt behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3, 4, 5];
  $expected = [[1, 2], [3, 4, 5]];

  $sut = $fun->splitAt(2, $list);
  expect($sut)->toBe($expected);
});

test('asserts splitEvery behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3, 4, 5, 6, 7];
  $expected = [[1, 2, 3], [4, 5, 6], [7]];

  $sut = $fun->splitEvery(3, $list);
  expect($sut)->toBe($expected);
});

test('asserts take behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3, 4, 5, 6, 7];
  $expected = [1, 2, 3];

  $sut = $fun->take(3, $list);
  expect($sut)->toBe($expected);
});

test('asserts takeLast behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3, 4, 5, 6, 7];
  $expected = [5, 6, 7];

  $sut = $fun->takeLast(3, $list);
  expect($sut)->toBe($expected);
});

test('asserts takeWhile behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3, 4, 5, 6, 7];
  $expected = [1, 2, 3, 4, 5];

  $sut = $fun->takeWhile(function ($element) {
    return $element < 6;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts takeLastWhile behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3, 4, 5, 6, 7];
  $expected = [6, 7];

  $sut = $fun->takeLastWhile(function ($element) {
    return $element > 5;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts tail behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3, 4, 5, 6, 7];
  $expected = [2, 3, 4, 5, 6, 7];

  $sut = $fun->tail($list);
  expect($sut)->toBe($expected);
});

test('asserts zip behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3, 4, 5, 6, 7];
  $other = ['one', 'two', 'three', 'four', 'five', 'six', 'seven'];
  $expected = [[1, 'one'], [2, 'two'], [3, 'three'], [4, 'four'], [5, 'five'], [6, 'six'], [7, 'seven']];

  $sut = $fun->zip($other, $list);
  expect($sut)->toBe($expected);
});

test('asserts zipWith behaves correctly', function () {
  $fun = new ListFunction();
  $list = [1, 2, 3, 4, 5, 6, 7];
  $other = ['one', 'two', 'three', 'four', 'five', 'six', 'seven'];
  $transform = function ($a, $b) {
    return "$a $b";
  };

  $expected = ['1 one', '2 two', '3 three', '4 four', '5 five', '6 six', '7 seven'];

  $sut = $fun->zipWith($other, $transform, $list);
  expect($sut)->toBe($expected);
});

test('asserts unzip behaves correctly', function () {
  $fun = new ListFunction();
  $input = [[1, 'one'], [2, 'two'], [3, 'three'], [4, 'four'], [5, 'five'], [6, 'six'], [7, 'seven']];
  $list = [1, 2, 3, 4, 5, 6, 7];
  $other = ['one', 'two', 'three', 'four', 'five', 'six', 'seven'];
  $expected = [$list, $other];

  $sut = $fun->unzip($input);
  expect($sut)->toBe($expected);
});

test('asserts where behaves correctly', function () {
  $fun = new ListFunction();
  $list = [
    ['name' => 'Orichalcum', 'rarity' => 3],
    ['name' => 'Mythril', 'rarity' => 5],
    ['name' => 'Gold', 'rarity' => 4],
    ['name' => 'Pixel', 'rarity' => 5],
    ['name' => 'Silver', 'rarity' => 2],
    ['name' => 'Bronze', 'rarity' => 1]
  ];

  $expected = [
    ['name' => 'Mythril', 'rarity' => 5],
    ['name' => 'Pixel', 'rarity' => 5]
  ];

  $sut = $fun->where('rarity', 5, $list);
  expect($sut)->toBe($expected);
});

test('asserts whereComparison behaves correctly', function () {
  $fun = new ListFunction();
  $list = [
    ['name' => 'Orichalcum', 'rarity' => 3],
    ['name' => 'Mythril', 'rarity' => 5],
    ['name' => 'Gold', 'rarity' => 4],
    ['name' => 'Pixel', 'rarity' => 5],
    ['name' => 'Silver', 'rarity' => 2],
    ['name' => 'Bronze', 'rarity' => 1]
  ];

  $expected = [
    ['name' => 'Orichalcum', 'rarity' => 3],
    ['name' => 'Mythril', 'rarity' => 5],
    ['name' => 'Gold', 'rarity' => 4],
    ['name' => 'Pixel', 'rarity' => 5],
  ];

  $sut = $fun->whereComparison('rarity', '>', 2, $list);
  expect($sut)->toBe($expected);
});

test('asserts whereBetween behaves correctly', function () {
  $fun = new ListFunction();
  $list = [
    ['name' => 'Orichalcum', 'rarity' => 3],
    ['name' => 'Mythril', 'rarity' => 5],
    ['name' => 'Gold', 'rarity' => 4],
    ['name' => 'Pixel', 'rarity' => 5],
    ['name' => 'Silver', 'rarity' => 2],
    ['name' => 'Bronze', 'rarity' => 1]
  ];

  $expected = [
    ['name' => 'Orichalcum', 'rarity' => 3],
    ['name' => 'Mythril', 'rarity' => 5],
    ['name' => 'Gold', 'rarity' => 4],
    ['name' => 'Pixel', 'rarity' => 5],
  ];

  $sut = $fun->whereBetween('rarity', 3, 5, $list);
  expect($sut)->toBe($expected);
});

test('asserts whereNotBetween behaves correctly', function () {
  $fun = new ListFunction();
  $list = [
    ['name' => 'Orichalcum', 'rarity' => 3],
    ['name' => 'Mythril', 'rarity' => 5],
    ['name' => 'Gold', 'rarity' => 4],
    ['name' => 'Pixel', 'rarity' => 5],
    ['name' => 'Silver', 'rarity' => 2],
    ['name' => 'Bronze', 'rarity' => 1]
  ];

  $expected = [
    ['name' => 'Silver', 'rarity' => 2],
    ['name' => 'Bronze', 'rarity' => 1]
  ];

  $sut = $fun->whereNotBetween('rarity', 3, 5, $list);
  expect($sut)->toBe($expected);
});


test('asserts whereIn behaves correctly', function () {
  $fun = new ListFunction();
  $list = [
    ['name' => 'Orichalcum', 'rarity' => 3],
    ['name' => 'Mythril', 'rarity' => 5],
    ['name' => 'Gold', 'rarity' => 4],
    ['name' => 'Pixel', 'rarity' => 5],
    ['name' => 'Silver', 'rarity' => 2],
    ['name' => 'Bronze', 'rarity' => 1]
  ];

  $expected = [
    ['name' => 'Orichalcum', 'rarity' => 3],
    ['name' => 'Bronze', 'rarity' => 1]
  ];

  $sut = $fun->whereIn('rarity', [1, 3], $list);
  expect($sut)->toBe($expected);
});

test('asserts whereNotIn behaves correctly', function () {
  $fun = new ListFunction();
  $list = [
    ['name' => 'Orichalcum', 'rarity' => 3],
    ['name' => 'Mythril', 'rarity' => 5],
    ['name' => 'Gold', 'rarity' => 4],
    ['name' => 'Pixel', 'rarity' => 5],
    ['name' => 'Silver', 'rarity' => 2],
    ['name' => 'Bronze', 'rarity' => 1]
  ];

  $expected = [
    ['name' => 'Mythril', 'rarity' => 5],
    ['name' => 'Gold', 'rarity' => 4],
    ['name' => 'Pixel', 'rarity' => 5],
    ['name' => 'Silver', 'rarity' => 2],
  ];

  $sut = $fun->whereNotIn('rarity', [1, 3], $list);
  expect($sut)->toBe($expected);
});
