<?php

use NoxImperium\Box\Box;

test('asserts all behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);
  $sut = $list->all(function ($value) {
    return $value > 0;
  });

  expect($sut)->toBe(true);
});

test('asserts any behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);
  $sut = $list->any(function ($value) {
    return $value % 2 === 0;
  });

  expect($sut)->toBe(true);
});

test('asserts adjust behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);
  $sut = $list->adjust(1, function ($val) {
    return $val + 20;
  });

  expect($sut->val())->toBe([1, 22, 3]);
});

test('asserts append behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);
  $sut = $list->append(20);

  expect($sut->val())->toBe([1, 2, 3, 20]);
});

test('asserts appendAll behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);
  $sut = $list->appendAll([20, 30, 40]);

  expect($sut->val())->toBe([1, 2, 3, 20, 30, 40]);
});

test('asserts average behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);
  $sut = $list->average($list);

  expect($sut)->toBe(2);
});

test('asserts contains behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);

  $sutOne = $list->contains(1);
  expect($sutOne)->toBe(true);

  $sutTwo = $list->contains(10);
  expect($sutTwo)->toBe(false);
});

test('asserts containsAll behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);

  $sutOne = $list->containsAll([1, 2]);
  expect($sutOne)->toBe(true);

  $sutTwo = $list->containsAll([1, 2, 10]);
  expect($sutTwo)->toBe(false);
});


test('asserts collectBy behaves correctly', function () {
  $list = Box::ofList([
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Kaka', 'title' => 'Grand Master'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
  ]);

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

  $sut = $list->collectBy(function ($element) {
    return $element['title'];
  });

  expect($sut)->toBe($expected);
});

test('asserts count behaves correctly', function () {
  $list = Box::ofList([1, 1, 2, 2, 3, 4, 5, 5, 3, 4, 4, 1, 2, 1, 1]);
  $sut = $list->count(function ($element) {
    return $element === 2;
  });

  $expected = 3;

  expect($sut)->toBe($expected);
});


test('asserts distinct behaves correctly', function () {
  $list = Box::ofList([1, 1, 2, 2, 3, 4, 5, 5, 3, 4, 4, 1, 2, 1, 1]);
  $sut = $list->distinct($list);

  $expected = [1, 2, 3, 4, 5];

  expect($sut->val())->toBe($expected);
});

test('asserts distinctBy behaves correctly', function () {
  $list = Box::ofList([
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Kaka', 'title' => 'Grand Master'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
  ]);

  $sut = $list->distinctBy(function ($element) {
    return $element['title'];
  });

  $expected = [
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Kaka', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
  ];

  expect($sut->val())->toBe($expected);
});

test('asserts drop behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);
  $sut = $list->drop(1);

  expect($sut->val())->toBe([2, 3]);
});

test('asserts dropWhile behaves correctly', function () {
  $list = Box::ofList([1, 2, 3, 4, 5, 6, 7]);
  $sut = $list->dropWhile(function ($element) {
    return  $element !== 3;
  });

  expect($sut->val())->toBe([3, 4, 5, 6, 7]);
});

test('asserts dropLast behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);
  $sut = $list->dropLast(1);

  expect($sut->val())->toBe([1, 2]);
});

test('asserts dropLastWhile behaves correctly', function () {
  $list = Box::ofList([1, 2, 3, 4, 5, 6, 7]);
  $sut = $list->dropLastWhile(function ($element) {
    return $element !== 3;
  });

  expect($sut->val())->toBe([1, 2]);
});

test('asserts dropRepeats behaves correctly', function () {
  $list = Box::ofList([1, 2, 2, 1, 3, 3, 3]);
  $sut = $list->dropRepeats($list);

  expect($sut->val())->toBe([1, 2, 1, 3]);
});

test('asserts dropRepeatsBy behaves correctly', function () {
  $list = Box::ofList([
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Kaka', 'title' => 'Grand Master'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
  ]);

  $sut = $list->dropRepeatsBy(function ($a, $b) {
    return $a['name'] !== $b['name'];
  });

  $expected = [
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
  ];

  expect($sut->val())->toBe($expected);
});

test('asserts endsWith behaves correctly', function () {
  $list = Box::ofList([1, 2, 3, 4, 5, 6]);
  $sut = $list->endsWith([4, 5, 6]);

  $expected = true;

  expect($sut)->toBe($expected);
});

test('asserts filter behaves correctly', function () {
  $list = Box::ofList([1, 2, 3, 4, 5, 6]);

  $sutEven = $list->filter(function ($val) {
    return $val % 2 === 0;
  });

  $expectedEven = [2, 4, 6];

  expect($sutEven->val())->toBe($expectedEven);

  $sutOdd = $list->filter(function ($val) {
    return $val % 2 !== 0;
  }, $list);

  $expectedOdd = [1, 3, 5];

  expect($sutOdd->val())->toBe($expectedOdd);
});

test('asserts filterIndexed behaves correctly', function () {
  $list = Box::ofList([0, 1, 2, 3, 3, 4, 5]);
  $sut = $list->filterIndexed(function ($idx, $val) {
    return $idx === $val;
  });

  $expected = [0, 1, 2, 3];

  expect($sut->val())->toBe($expected);
});

test('asserts filterNot behaves correctly', function () {
  $list = Box::ofList([
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
    ['name' => 'Tulen', 'title' => 'Pro'],
    ['name' => 'Ilumia', 'title' => 'Grandeur'],
  ]);

  $sut = $list->filterNot(function ($val) {
    return $val['title'] === 'Grandeur';
  });

  $expected = [
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Tulen', 'title' => 'Pro'],
  ];

  expect($sut->val())->toBe($expected);
});

test('asserts filterNotIndexed behaves correctly', function () {
  $list = Box::ofList([
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
    ['name' => 'Tulen', 'title' => 'Pro'],
    ['name' => 'Ilumia', 'title' => 'Grandeur'],
  ]);

  $sut = $list->filterNotIndexed(function ($index, $value) {
    return $index > 2;
  });

  $expected = [
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
  ];

  expect($sut->val())->toBe($expected);
});

test('asserts filterNotNull behaves correctly', function () {
  $list = Box::ofList([1, 5, null, 0, null, 2, 3, null]);
  $sut = $list->filterNotNull($list);

  $expected = [1, 5, 0, 2, 3];

  expect($sut->val())->toBe($expected);
});

test('asserts find behaves correctly', function () {
  $list = Box::ofList([
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
    ['name' => 'Tulen', 'title' => 'Pro'],
    ['name' => 'Ilumia', 'title' => 'Grandeur'],
  ]);

  $sut = $list->find(function ($val) {
    return $val['title'] === 'Grandeur';
  });

  $expected = ['name' => 'Alex', 'title' => 'Grandeur'];

  expect($sut)->toBe($expected);
});

test('asserts findLast behaves correctly', function () {
  $list = Box::ofList([
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
    ['name' => 'Tulen', 'title' => 'Pro'],
    ['name' => 'Ilumia', 'title' => 'Grandeur'],
  ]);

  $sut = $list->findLast(function ($val) {
    return $val['title'] === 'Grandeur';
  });

  $expected = ['name' => 'Ilumia', 'title' => 'Grandeur'];

  expect($sut)->toBe($expected);
});

test('asserts findIndex behaves correctly', function () {
  $list = Box::ofList([10, 20, 30]);
  $sut = $list->findIndex(10);

  $expected = 0;

  expect($sut)->toBe($expected);
});

test('asserts findLastIndex behaves correctly', function () {
  $list = Box::ofList([10, 20, 30, 20, 10]);
  $sut = $list->findLastIndex(20);

  $expected = 3;

  expect($sut)->toBe($expected);
});


test('asserts first on non-empty array', function () {
  $list = Box::ofList([
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
  ]);

  $sut = $list->first($list);

  $expected = ['name' => 'Kaka', 'title' => 'Pro'];

  expect($sut)->toBe($expected);
});

test('asserts first on empty array', function () {
  $list = Box::ofList([]);

  $list->first($list);
})->throws(Exception::class, 'The List is empty.');

test('asserts firstOrNull on non-empty array', function () {
  $list = Box::ofList([
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
  ]);

  $sut = $list->firstOrNull($list);

  $expected = ['name' => 'Kaka', 'title' => 'Pro'];

  expect($sut)->toBe($expected);
});

test('asserts firstOrNull on empty array', function () {
  $list = Box::ofList([]);

  $sut = $list->firstOrNull($list);

  $expected = null;

  expect($sut)->toBe($expected);
});

test('asserts flatMap behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);

  $sut = $list->flatMap(function ($val) {
    return [$val, $val + 1, $val + 2];
  });

  $expected = [1, 2, 3, 2, 3, 4, 3, 4, 5];

  expect($sut->val())->toBe($expected);
});

test('asserts flatMapIndexed behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);

  $sut = $list->flatMapIndexed(function ($key, $val) {
    return  ["$key $val", "$val $key"];
  });

  $expected = ['0 1', '1 0', '1 2', '2 1', '2 3', '3 2'];

  expect($sut->val())->toBe($expected);
});

test('asserts flatten behaves correctly', function () {
  $list = Box::ofList([1, [2, 3], [4], [5, 6, 7], [8, 9]]);

  $expected = [1, 2, 3, 4, 5, 6, 7, 8, 9];

  $sut = $list->flatten($list);

  expect($sut->val())->toBe($expected);
});

test('asserts fold behaves correctly', function () {
  $list = Box::ofList([10, 20, 30]);

  $sut = $list->fold(100, function ($acc, $cur) {
    return $acc + $cur;
  });

  $expected = 160;

  expect($sut)->toBe($expected);
});

test('asserts foldIndexed behaves correctly', function () {
  $list = Box::ofList([10, 20, 30]);

  $sut = $list->foldIndexed(100, function ($idx, $acc, $cur) {
    return $idx + $acc + $cur;
  });

  $expected = 163;

  expect($sut)->toBe($expected);
});

test('asserts foldRight behaves correctly', function () {
  $list = Box::ofList([10, 20, 30]);

  $sut = $list->fold(50, function ($acc, $cur) {
    return $acc - $cur;
  });

  $expected = -10;

  expect($sut)->toBe($expected);
});

test('asserts foldRightIndexed behaves correctly', function () {
  $list = Box::ofList([10, 20, 30]);

  $sut = $list->foldIndexed(50, function ($acc, $idx, $cur) {
    return $acc - $cur - $idx;
  }, $list);

  $expected = -13;

  expect($sut)->toBe($expected);
});

test('asserts forEach behaves correctly', function () {
  $list = Box::ofList([10, 20, 30]);

  $expected = [10, 20, 30];

  $sut = [];
  $list->forEach(function ($value) use (&$sut) {
    $sut[] = $value;
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts forEachIndexed behaves correctly', function () {
  $list = Box::ofList([10, 20, 30]);

  $expected = [
    "Index: 0 | Value: 10",
    "Index: 1 | Value: 20",
    "Index: 2 | Value: 30"
  ];

  $sut = [];
  $list->forEachIndexed(function ($idx, $val) use (&$sut) {
    $sut[] = "Index: $idx | Value: $val";
  }, $list);

  expect($sut)->toBe($expected);
});

test('asserts get on existing index', function () {
  $list = Box::ofList([10, 20, 30]);

  $sut = $list->get(0, $list);

  $expected = 10;

  expect($sut)->toBe($expected);
});

test('asserts get on non-existing index', function () {
  $list = Box::ofList([10, 20, 30]);

  $list->get(10, $list);
})->throws(Exception::class);

test('asserts getOrElse on existing index', function () {
  $list = Box::ofList([10, 20, 30]);

  $sut = $list->getOrElse(0, 'Not found', $list);

  $expected = 10;
  expect($sut)->toBe($expected);
});

test('asserts getOrElse on non-existing index', function () {
  $list = Box::ofList([10, 20, 30]);

  $sut = $list->getOrElse(10, 'Not found', $list);

  $expected = 'Not found';

  expect($sut)->toBe($expected);
});

test('asserts getOrNull on existing index', function () {
  $list = Box::ofList([10, 20, 30]);

  $sut = $list->getOrNull(0);

  $expected = 10;

  expect($sut)->toBe($expected);
});

test('asserts getOrNull on non-existing index', function () {
  $list = Box::ofList([10, 20, 30]);

  $sut = $list->getOrNull(10, $list);

  $expected = null;

  expect($sut)->toBe($expected);
});

test('asserts getOnPath on existing index', function () {
  $list = Box::ofList([
    [
      'name' => 'Kaka',
      'age' => '21',
    ],
    [
      'name' => 'Enzo',
      'age' => '24',
    ]
  ]);

  $sut = $list->getOnPath('1.name', $list);

  expect($sut)->toBe('Enzo');
});

test('asserts getOnPath on non-existing index', function () {
  $list = Box::ofList([
    [
      'name' => 'Kaka',
      'age' => '21',
    ],
    [
      'name' => 'Enzo',
      'age' => '24',
    ]
  ]);

  $list->getOnPath('0.address', $list);
})->throws('Path not found.');

test('asserts getOnPathOrElse behaves correctly', function () {
  $list = Box::ofList([
    [
      'name' => 'Kaka',
      'age' => '21',
    ],
    [
      'name' => 'Enzo',
      'age' => '24',
    ]
  ]);

  $sutOne = $list->getOnPathOrElse('1.name', 'No Name', $list);
  expect($sutOne)->toBe('Enzo');

  $sutTwo = $list->getOnPathOrElse('4.name', 'No Name', $list);
  expect($sutTwo)->toBe('No Name');
});

test('asserts getOnPathOrNull behaves correctly', function () {
  $list = Box::ofList([
    [
      'name' => 'Kaka',
      'age' => '21',
    ],
    [
      'name' => 'Enzo',
      'age' => '24',
    ]
  ]);

  $sutOne = $list->getOnPathOrNull('1.name', $list);
  expect($sutOne)->toBe('Enzo');

  $sutTwo = $list->getOnPathOrNull('4.name', $list);
  expect($sutTwo)->toBe(null);
});

test('asserts getOnPaths behaves correctly', function () {
  $list = Box::ofList([
    [
      'name' => 'Kaka',
      'age' => '21',
    ],
    [
      'name' => 'Enzo',
      'age' => '24',
    ]
  ]);

  $sut = $list->getOnPaths(['0.name', '0.age', '1.name', '1.age', '2.name', '2.age'], $list);
  expect($sut->val())->toBe(['Kaka', '21', 'Enzo', '24', null, null]);
});

test('asserts groupBy behaves correctly', function () {
  $list = Box::ofList([10, 20, 30, 100, 120, 150]);

  $expected = [
    'Tens' => [10, 20, 30],
    'Hundreds' => [100, 120, 150],
  ];

  $sut = $list->groupBy(function ($value) {
    return $value >= 100 ? 'Hundreds' : 'Tens';
  }, null);

  expect($sut->val())->toBe($expected);
});

// TODO
test('asserts groupByKeyed behaves correctly', function () {
});

test('asserts getOnPath behaves correctly', function () {
  $list = Box::ofList([
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
  ]);

  $sut = $list->getOnPath("1.age");

  $expected = '20';

  expect($sut)->toBe($expected);
});

test('asserts head behaves correctly', function () {
  $list = Box::ofList([10, 20, 30]);

  $sut = $list->head($list);

  $expected = 10;

  expect($sut)->toBe($expected);
});

test('asserts insert behaves correctly', function () {
  $list = Box::ofList([10, 20, 30]);

  $sut = $list->insert(2, 100);

  $expected = [10, 20, 100, 30];

  expect($sut->val())->toBe($expected);
});

test('asserts insertAll with array behaves correctly', function () {
  $list = Box::ofList([10, 20, 30]);

  $sut = $list->insertAll(2, [100, 200]);

  $expected = [10, 20, 100, 200, 30];

  expect($sut->val())->toBe($expected);
});

test('asserts insertAll with single value behaves correctly', function () {
  $list = Box::ofList([10, 20, 30]);

  $sut = $list->insertAll(2, 100, $list);

  $expected = [10, 20, 100, 30];

  expect($sut->val())->toBe($expected);
});

test('asserts last behaves correctly', function () {
  $list = Box::ofList([10, 20, 30]);

  $sut = $list->last($list);

  $expected = 30;

  expect($sut)->toBe($expected);
});

test('asserts map behaves correctly', function () {
  $list = Box::ofList(['Kaka', 'Enzo', 'Zata']);

  $expected = [
    ['name' => 'Kaka', 'age' => '-'],
    ['name' => 'Enzo', 'age' => '-'],
    ['name' => 'Zata', 'age' => '-'],
  ];

  $sut = $list->map(function ($element) {
    return ['name' => $element, 'age' => '-'];
  });

  expect($sut->val())->toBe($expected);
});

test('asserts mapIndexed behaves correctly', function () {
  $list = Box::ofList(['Kaka', 'Enzo', 'Zata']);

  $expected = [
    ['name' => 'Kaka', 'index' => 0, 'age' => '-'],
    ['name' => 'Enzo', 'index' => 1, 'age' => '-'],
    ['name' => 'Zata', 'index' => 2, 'age' => '-'],
  ];

  $sut = $list->mapIndexed(function ($index, $element) {
    return ['name' => $element, 'index' => $index, 'age' => '-'];
  });

  expect($sut->val())->toBe($expected);
});

test('asserts mapNotNull behaves correctly', function () {
  $list = Box::ofList(['Kaka', 'Enzo', 'Zata', null, 'Tulen']);

  $expected = [
    ['name' => 'Kaka', 'age' => '-'],
    ['name' => 'Enzo', 'age' => '-'],
    ['name' => 'Zata', 'age' => '-'],
    ['name' => 'Tulen', 'age' => '-'],
  ];

  $sut = $list->mapNotNull(function ($element) {
    if ($element === null) return null;

    return ['name' => $element, 'age' => '-'];
  });

  expect($sut->val())->toBe($expected);
});

test('asserts mapIndexedNotNull behaves correctly', function () {
  $list = Box::ofList(['Kaka', 'Enzo', 'Zata', null, 'Tulen']);

  $expected = [
    ['name' => 'Kaka', 'index' => 0, 'age' => '-'],
    ['name' => 'Enzo', 'index' => 1, 'age' => '-'],
    ['name' => 'Zata', 'index' => 2, 'age' => '-'],
    ['name' => 'Tulen', 'index' => 4, 'age' => '-'],
  ];

  $sut = $list->mapIndexedNotNull(function ($index, $element) {
    if ($element === null) return null;

    return ['name' => $element, 'index' => $index, 'age' => '-'];
  });

  expect($sut->val())->toBe($expected);
});

test('asserts max behaves correctly', function () {
  $list = Box::ofList([10, 20, 30, 10, 100, 80, 20]);

  $sut = $list->max($list);

  $expected = 100;

  expect($sut)->toBe($expected);
});

test('asserts min behaves correctly', function () {
  $list = Box::ofList([10, 20, 30, 10, 100, 80, 20]);

  $sut = $list->min($list);

  $expected = 10;

  expect($sut)->toBe($expected);
});

test('asserts none behaves correctly', function () {
  $list = Box::ofList([10, 20, 30]);

  $sut = $list->none(function ($element) {
    return $element > 100;
  });

  $expected = true;

  expect($sut)->toBe($expected);
});

test('asserts pluck behaves correctly', function () {
  $list = Box::ofList([
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
  ]);


  $sut = $list->pluck('contact.line', null, $list);

  $expected = ['@atlas', '@rui', '@kaka', '@gildur'];

  expect($sut->val())->toBe($expected);
});

test('asserts partition behaves correctly', function () {
  $list = Box::ofList([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

  $expected = [
    [2, 4, 6, 8, 10],
    [1, 3, 5, 7, 9],
  ];

  $sut = $list->partition(function ($element) {
    return $element % 2 === 0;
  });

  expect($sut->val())->toBe($expected);
});

test('asserts prepend behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);
  $expected = [10, 1, 2, 3];

  $sut = $list->prepend(10);
  expect($sut->val())->toBe($expected);
});

test('asserts prependAll behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);

  $sut = $list->prependAll([10, 11, 12], $list);

  $expected = [10, 11, 12, 1, 2, 3];

  expect($sut->val())->toBe($expected);
});

test('asserts reduce on non-empty list behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);

  $sut = $list->reduce(function ($accumulator, $element) {
    return $accumulator + $element;
  });

  $expected = 6;

  expect($sut)->toBe($expected);
});

test('asserts reduce on empty list behaves correctly', function () {
  $list = Box::ofList([]);

  $list->reduce(function ($accumulator, $element) {
    return $accumulator + $element;
  });
})->throws('List is empty.');

test('asserts reduceOrNull on non-empty list behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);

  $sut = $list->reduceOrNull(function ($accumulator, $element) {
    return $accumulator + $element;
  });

  $expected = 6;

  expect($sut)->toBe($expected);
});

test('asserts reduceOrNull on empty list behaves correctly', function () {
  $list = Box::ofList([]);

  $sut = $list->reduceOrNull(function ($accumulator, $element) {
    return $accumulator + $element;
  });

  $expected = null;

  expect($sut)->toBe($expected);
});

test('asserts reduceIndexed on non-empty list behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);

  $sut = $list->reduceIndexed(function ($accumulator, $index, $element) {
    return $accumulator + $index + $element;
  });

  $expected = 9;

  expect($sut)->toBe($expected);
});

test('asserts reduceIndexed on empty list behaves correctly', function () {
  $list = Box::ofList([]);

  $list->reduce(function ($accumulator, $index, $element) {
    return $accumulator + $index + $element;
  });
})->throws('List is empty.');

test('asserts reduceRight on non-empty list behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);

  $sut = $list->reduceRight(function ($accumulator, $element) {
    return $accumulator + $element;
  });

  $expected = 6;

  expect($sut)->toBe($expected);
});

test('asserts reduceRight on empty list behaves correctly', function () {
  $list = Box::ofList([]);

  $list->reduceRight(function ($accumulator, $element) {
    return $accumulator + $element;
  });
})->throws('List is empty.');

test('asserts reduceRightOrNull on non-empty list behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);
  $sut = $list->reduceRightOrNull(function ($accumulator, $element) {
    return $accumulator + $element;
  });

  $expected = 6;

  expect($sut)->toBe($expected);
});

test('asserts reduceRightOrNull on empty list behaves correctly', function () {
  $list = Box::ofList([]);

  $sut = $list->reduceRightOrNull(function ($accumulator, $element) {
    return $accumulator + $element;
  });

  $expected = null;

  expect($sut)->toBe($expected);
});

test('asserts reverse behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);

  $sut = $list->reverse($list);

  $expected = [3, 2, 1];

  expect($sut->val())->toBe($expected);
});

test('asserts runningFold behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);

  $sut = $list->runningFold(0, function ($accumulator, $element) {
    return $accumulator + $element;
  });

  $expected = [0, 1, 3, 6];

  expect($sut->val())->toBe($expected);
});

test('asserts runningFoldIndexed behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);

  $sut = $list->runningFoldIndexed(0, function ($accumulator, $index, $element) {
    return $accumulator + $index + $element;
  });

  $expected = [0, 1, 4, 9];

  expect($sut->val())->toBe($expected);
});

test('asserts runningFoldRight behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);

  $sut = $list->runningFoldRight(0, function ($accumulator, $element) {
    return $accumulator + $element;
  });

  $expected = [0, 3, 5, 6];

  expect($sut->val())->toBe($expected);
});

test('asserts runningFoldRightIndexed behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);

  $sut = $list->runningFoldRightIndexed(0, function ($accumulator, $index, $element) {
    return $accumulator + $index + $element;
  });

  $expected = [0, 5, 8, 9];

  expect($sut->val())->toBe($expected);
});

test('asserts runningReduce behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);

  $sut = $list->runningReduce(function ($accumulator, $element) {
    return $accumulator + $element;
  });

  $expected = [1, 3, 6];

  expect($sut->val())->toBe($expected);
});

test('asserts runningReduceIndexed behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);

  $sut = $list->runningReduceIndexed(function ($accumulator, $index, $element) {
    return $accumulator + $index + $element;
  });

  $expected = [1, 4, 9];

  expect($sut->val())->toBe($expected);
});

test('asserts runningReduceRight behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);

  $sut = $list->runningReduceRight(function ($accumulator, $element) {
    return $accumulator + $element;
  });

  $expected = [3, 5, 6];

  expect($sut->val())->toBe($expected);
});

test('asserts runningReduceRightIndexed behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);

  $sut = $list->runningReduceRightIndexed(function ($accumulator, $index, $element) {
    return $accumulator + $index + $element;
  });

  $expected = [3, 6, 7];

  expect($sut->val())->toBe($expected);
});

test('asserts sum behaves correctly', function () {
  $list = Box::ofList([1, 2, 3]);

  $sut = $list->sum($list);

  $expected = 6;

  expect($sut)->toBe($expected);
});

test('asserts startsWith behaves correctly', function () {
  $list = Box::ofList([1, 2, 3, 4, 5, 6]);

  $sut = $list->startsWith([1, 2, 3]);

  $expected = true;

  expect($sut)->toBe($expected);
});

test('asserts slice behaves correctly', function () {
  $list = Box::ofList([1, 2, 3, 4, 5, 6]);

  $sut = $list->slice(1, 3);

  $expected = [2, 3];

  expect($sut->val())->toBe($expected);
});

test('asserts sortBy behaves correctly', function () {
  $list = Box::ofList([
    ['name' => 'Orichalcum', 'rarity' => 3],
    ['name' => 'Mythril', 'rarity' => 5],
    ['name' => 'Gold', 'rarity' => 4],
    ['name' => 'Silver', 'rarity' => 2],
    ['name' => 'Bronze', 'rarity' => 1],
  ]);

  $expected = [
    ['name' => 'Bronze', 'rarity' => 1],
    ['name' => 'Silver', 'rarity' => 2],
    ['name' => 'Orichalcum', 'rarity' => 3],
    ['name' => 'Gold', 'rarity' => 4],
    ['name' => 'Mythril', 'rarity' => 5],
  ];

  $sut = $list->sortBy(function ($element) {
    return $element['rarity'];
  });

  expect($sut->val())->toBe($expected);
});

test('asserts sortByDescending behaves correctly', function () {
  $list = Box::ofList([
    ['name' => 'Orichalcum', 'rarity' => 3],
    ['name' => 'Mythril', 'rarity' => 5],
    ['name' => 'Gold', 'rarity' => 4],
    ['name' => 'Silver', 'rarity' => 2],
    ['name' => 'Bronze', 'rarity' => 1],
  ]);

  $sut = $list->sortByDescending(function ($element) {
    return $element['rarity'];
  });

  $expected = [
    ['name' => 'Mythril', 'rarity' => 5],
    ['name' => 'Gold', 'rarity' => 4],
    ['name' => 'Orichalcum', 'rarity' => 3],
    ['name' => 'Silver', 'rarity' => 2],
    ['name' => 'Bronze', 'rarity' => 1],
  ];

  expect($sut->val())->toBe($expected);
});

test('asserts splitAt behaves correctly', function () {
  $list = Box::ofList([1, 2, 3, 4, 5]);

  $sut = $list->splitAt(2);

  $expected = [[1, 2], [3, 4, 5]];

  expect($sut->val())->toBe($expected);
});

test('asserts splitEvery behaves correctly', function () {
  $list = Box::ofList([1, 2, 3, 4, 5, 6, 7]);

  $sut = $list->splitEvery(3);

  $expected = [[1, 2, 3], [4, 5, 6], [7]];

  expect($sut->val())->toBe($expected);
});

test('asserts take behaves correctly', function () {
  $list = Box::ofList([1, 2, 3, 4, 5, 6, 7]);

  $sut = $list->take(3);

  $expected = [1, 2, 3];

  expect($sut->val())->toBe($expected);
});

test('asserts takeLast behaves correctly', function () {
  $list = Box::ofList([1, 2, 3, 4, 5, 6, 7]);

  $sut = $list->takeLast(3);

  $expected = [5, 6, 7];

  expect($sut->val())->toBe($expected);
});

test('asserts takeWhile behaves correctly', function () {
  $list = Box::ofList([1, 2, 3, 4, 5, 6, 7]);

  $expected = [1, 2, 3, 4, 5];

  $sut = $list->takeWhile(function ($element) {
    return $element < 6;
  });

  expect($sut->val())->toBe($expected);
});

test('asserts takeLastWhile behaves correctly', function () {
  $list = Box::ofList([1, 2, 3, 4, 5, 6, 7]);

  $sut = $list->takeLastWhile(function ($element) {
    return $element > 5;
  });

  $expected = [6, 7];

  expect($sut->val())->toBe($expected);
});

test('asserts tail behaves correctly', function () {
  $list = Box::ofList([1, 2, 3, 4, 5, 6, 7]);

  $sut = $list->tail($list);

  $expected = [2, 3, 4, 5, 6, 7];

  expect($sut->val())->toBe($expected);
});

test('asserts zip behaves correctly', function () {
  $list = Box::ofList([1, 2, 3, 4, 5, 6, 7]);
  $other = ['one', 'two', 'three', 'four', 'five', 'six', 'seven'];

  $sut = $list->zip($other, $list);

  $expected = [[1, 'one'], [2, 'two'], [3, 'three'], [4, 'four'], [5, 'five'], [6, 'six'], [7, 'seven']];

  expect($sut->val())->toBe($expected);
});

test('asserts zipWith behaves correctly', function () {
  $list = Box::ofList([1, 2, 3, 4, 5, 6, 7]);
  $other = ['one', 'two', 'three', 'four', 'five', 'six', 'seven'];

  $transform = function ($a, $b) {
    return "$a $b";
  };

  $sut = $list->zipWith($other, $transform, $list);

  $expected = ['1 one', '2 two', '3 three', '4 four', '5 five', '6 six', '7 seven'];

  expect($sut->val())->toBe($expected);
});

test('asserts unzip behaves correctly', function () {
  $list = Box::ofList([[1, 'one'], [2, 'two'], [3, 'three'], [4, 'four'], [5, 'five'], [6, 'six'], [7, 'seven']]);

  $other1 = [1, 2, 3, 4, 5, 6, 7];
  $other2 = ['one', 'two', 'three', 'four', 'five', 'six', 'seven'];

  $sut = $list->unzip();

  $expected = [$other1, $other2];

  expect($sut->val())->toBe($expected);
});
