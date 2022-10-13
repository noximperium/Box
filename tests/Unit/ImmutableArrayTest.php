<?php

use NoxImperium\Container\ImmutableArray;

test('asserts instance of ImmutableArray', function () {
  $container = ImmutableArray::of([]);
  $type = get_class($container);

  expect($type)->toBe('NoxImperium\\Container\\ImmutableArray');
});

test('asserts initial content of ImmutableArray is empty', function () {
  $container = ImmutableArray::of([]);
  $val = $container->val();
  $length = count($val);

  expect($length)->toBe(0);
});

test('asserts ImmutableArray::repeat behaves correctly', function () {
  $container = ImmutableArray::repeat(10, 5);
  $val = $container->val();
  $length = count($val);

  expect($length)->toBe(5);
  expect($val[0])->toBe(10);
});

test('asserts adjust behaves correctly', function () {
  $container = ImmutableArray::of([1, 2, 3]);

  $sut = $container
    ->adjust(1, function ($val) {
      return $val + 20;
    })
    ->get(1);

  expect($sut)->toBe(22);
});

test('asserts aperture behaves correctly', function () {
  $container = ImmutableArray::of([1, 2, 3, 4]);

  $sutOne = $container
    ->aperture(2)
    ->val();

  expect($sutOne)->toBe([[1, 2], [2, 3], [3, 4]]);

  $sutTwo = $container
    ->aperture(3)
    ->val();

  expect($sutTwo)->toBe([[1, 2, 3], [2, 3, 4]]);
});

test('asserts append behaves correctly', function () {
  $container = ImmutableArray::of([1, 2, 3]);

  $sut = $container
    ->append(20)
    ->last();

  expect($sut)->toBe(20);
});

test('asserts concat behaves correctly', function () {
  $container = ImmutableArray::of([1, 2, 3]);

  $sut = $container
    ->concat(['a', 'b'])
    ->val();

  expect($sut)->toBe([1, 2, 3, 'a', 'b']);
});

test('asserts distinct behaves correctly', function () {
  $container = ImmutableArray::of([1, 1, 2, 2, 3, 4, 5, 5, 3, 4, 4, 1, 2, 1, 1]);

  $sut = $container
    ->distinct()
    ->val();

  expect($sut)->toBe([1, 2, 3, 4, 5]);
});


test('asserts drop behaves correctly', function () {
  $container = ImmutableArray::of([1, 2, 3]);

  $sutOne = $container
    ->drop(2)
    ->val();

  expect($sutOne)->toBe([3]);

  $sutTwo = $container
    ->drop(0)
    ->val();

  expect($sutTwo)->toBe([1, 2, 3]);
});

test('asserts dropLast behaves correctly', function () {
  $container = ImmutableArray::of([1, 2, 3]);

  $sutOne = $container
    ->dropLast(2)
    ->val();

  expect($sutOne)->toBe([1]);

  $sutTwo = $container
    ->dropLast(0)
    ->val();

  expect($sutTwo)->toBe([1, 2, 3]);
});

test('asserts dropLastWhile behaves correctly', function () {
  $container = ImmutableArray::of([1, 2, 3, 4, 5, 6, 7]);

  $sutOne = $container
    ->dropLastWhile(function ($val) {
      return $val > 5;
    })
    ->val();

  expect($sutOne)->toBe([1, 2, 3, 4, 5]);

  $sutTwo = $container
    ->dropLastWhile(function ($val) {
      return $val > 5;
    })
    ->val();

  expect($sutTwo)->toBe([1, 2, 3, 4, 5]);
});

test('asserts dropWhile behaves correctly', function () {
  $container = ImmutableArray::of([1, 2, 3, 4, 5, 6, 7]);

  $sutOne = $container
    ->dropWhile(function ($val) {
      return  $val < 5;
    })
    ->val();

  expect($sutOne)->toBe([5, 6, 7]);

  $sutTwo = $container
    ->dropWhile(function ($val) {
      return  $val > 0;
    })
    ->val();

  expect($sutTwo)->toBe([]);
});

test('asserts dropRepeats behaves correctly', function () {
  $container = ImmutableArray::of([1, 2, 2, 1, 3, 3, 3]);

  $sut = $container
    ->dropRepeats()
    ->val();

  expect($sut)->toBe([1, 2, 1, 3]);
});

test('asserts dropRepeatsWith behaves correctly', function () {
  $container = ImmutableArray::of([
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Kaka', 'title' => 'Grand Master'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
  ]);

  $sut = $container
    ->dropRepeatsWith(function ($a, $b) {
      return $a['name'] !== $b['name'];
    })
    ->val();

  expect($sut)->toBe([
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
  ]);
});

test('asserts filter behaves correctly', function () {
  $container = ImmutableArray::of([1, 2, 3, 4, 5, 6]);
  $containerTwo = ImmutableArray::of([
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
    ['name' => 'Tulen', 'title' => 'Pro'],
    ['name' => 'Ilumia', 'title' => 'Grandeur'],
  ]);

  $sutEven = $container
    ->filter(function ($val) {
      return $val % 2 === 0;
    })
    ->val();

  expect($sutEven)->toBe([2, 4, 6]);

  $sutOdd = $container
    ->filter(function ($val) {
      return $val % 2 !== 0;
    })
    ->val();

  expect($sutOdd)->toBe([1, 3, 5]);

  $sutGrandeur = $containerTwo
    ->filter(function ($val) {
      return  $val['title'] === 'Grandeur';
    })
    ->val();

  expect($sutGrandeur)->toBe([
    ['name' => 'Alex', 'title' => 'Grandeur'],
    ['name' => 'Ilumia', 'title' => 'Grandeur'],
  ]);
});

test('asserts filterIndexed behaves correctly', function () {
  $container = ImmutableArray::of([0, 1, 2, 3, 3, 4, 5]);

  $sut = $container
    ->filterIndexed(function ($idx, $val) {
      return $idx === $val;
    })
    ->val();

  expect($sut)->toBe([0, 1, 2, 3]);
});

test('asserts filterNot behaves correctly', function () {
  $container = ImmutableArray::of([
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
    ['name' => 'Tulen', 'title' => 'Pro'],
    ['name' => 'Ilumia', 'title' => 'Grandeur'],
  ]);

  $sut = $container
    ->filterNot(function ($val) {
      return $val['title'] === 'Grandeur';
    })
    ->val();

  expect($sut)->toBe([
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Tulen', 'title' => 'Pro'],
  ]);
});

test('asserts filterNotNull behaves correctly', function () {
  $container = ImmutableArray::of([1, 5, null, 0, null, 2, 3, null]);

  $sut = $container
    ->filterNotNull()
    ->val();

  expect($sut)->toBe([1, 5, 0, 2, 3]);
});

test('asserts find behaves correctly', function () {
  $container = ImmutableArray::of([
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
    ['name' => 'Tulen', 'title' => 'Pro'],
    ['name' => 'Ilumia', 'title' => 'Grandeur'],
  ]);

  $sut = $container
    ->find(function ($val) {
      return $val['title'] === 'Grandeur';
    });

  expect($sut)->toBe(['name' => 'Alex', 'title' => 'Grandeur']);
});

test('asserts findLast behaves correctly', function () {
  $container = ImmutableArray::of([
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
    ['name' => 'Alex', 'title' => 'Grandeur'],
    ['name' => 'Tulen', 'title' => 'Pro'],
    ['name' => 'Ilumia', 'title' => 'Grandeur'],
  ]);

  $sut = $container
    ->findLast(function ($val) {
      return $val['title'] === 'Grandeur';
    });

  expect($sut)->toBe(['name' => 'Ilumia', 'title' => 'Grandeur']);
});

test('asserts first on non-empty array', function () {
  $container = ImmutableArray::of([
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
  ]);

  $sut = $container->first();
  expect($sut)->toBe(['name' => 'Kaka', 'title' => 'Pro']);
});

test('asserts first on empty array', function () {
  $container = ImmutableArray::of([]);
  $container->first();
})->throws(Exception::class, 'The array is empty.');

test('asserts firstNotNullOf on non-empty array', function () {
  $container = ImmutableArray::of([
    ['name' => 'Kaka', 'title' => 'Pro', 'todays_match' => null],
    ['name' => 'Rui', 'title' => 'Grand Master', 'todays_match' => 2],
    ['name' => 'Alex', 'title' => 'Grandeur', 'todays_match' => null],
    ['name' => 'Tulen', 'title' => 'Pro', 'todays_match' => null],
    ['name' => 'Ilumia', 'title' => 'Grandeur', 'todays_match' => 5],
  ]);

  $sut = $container->firstNotNullOf(function ($val) {
    return $val['todays_match'];
  });

  expect($sut)->toBe(['name' => 'Rui', 'title' => 'Grand Master', 'todays_match' => 2]);
});

test('asserts firstNotNullOf on non matching elements', function () {
  $container = ImmutableArray::of([
    ['name' => 'Kaka', 'title' => 'Pro', 'todays_match' => null],
    ['name' => 'Rui', 'title' => 'Grand Master', 'todays_match' => null],
    ['name' => 'Alex', 'title' => 'Grandeur', 'todays_match' => null],
    ['name' => 'Tulen', 'title' => 'Pro', 'todays_match' => null],
    ['name' => 'Ilumia', 'title' => 'Grandeur', 'todays_match' => null],
  ]);

  $container->firstNotNullOf(function ($val) {
    return $val['todays_match'];
  });
})->throws(Exception::class, 'No such element found.');

test('asserts firstNotNullOfOrNull on non-empty array', function () {
  $container = ImmutableArray::of([
    ['name' => 'Kaka', 'title' => 'Pro', 'todays_match' => null],
    ['name' => 'Rui', 'title' => 'Grand Master', 'todays_match' => 2],
    ['name' => 'Alex', 'title' => 'Grandeur', 'todays_match' => null],
    ['name' => 'Tulen', 'title' => 'Pro', 'todays_match' => null],
    ['name' => 'Ilumia', 'title' => 'Grandeur', 'todays_match' => 5],
  ]);

  $sut = $container->firstNotNullOfOrNull(function ($val) {
    return $val['todays_match'];
  });

  expect($sut)->toBe(['name' => 'Rui', 'title' => 'Grand Master', 'todays_match' => 2]);
});

test('asserts firstNotNullOfOrNull on non matching elements', function () {
  $container = ImmutableArray::of([
    ['name' => 'Kaka', 'title' => 'Pro', 'todays_match' => null],
    ['name' => 'Rui', 'title' => 'Grand Master', 'todays_match' => null],
    ['name' => 'Alex', 'title' => 'Grandeur', 'todays_match' => null],
    ['name' => 'Tulen', 'title' => 'Pro', 'todays_match' => null],
    ['name' => 'Ilumia', 'title' => 'Grandeur', 'todays_match' => null],
  ]);

  $sut = $container->firstNotNullOfOrNull(function ($val) {
    return $val['todays_match'];
  });

  expect($sut)->toBe(null);
});

test('asserts firstOrNull on non-empty array', function () {
  $container = ImmutableArray::of([
    ['name' => 'Kaka', 'title' => 'Pro'],
    ['name' => 'Rui', 'title' => 'Grand Master'],
  ]);

  $sut = $container->firstOrNull();
  expect($sut)->toBe(['name' => 'Kaka', 'title' => 'Pro']);
});

test('asserts firstOrNull on empty array', function () {
  $container = ImmutableArray::of([]);

  $sut = $container->firstOrNull();
  expect($sut)->toBe(null);
});

test('asserts flatMap behaves correctly', function () {
  $container = ImmutableArray::of([1, 2, 3]);

  $flatMapped = $container->flatMap(function ($val) {
    return [$val, $val + 1, $val + 2];
  });

  $sut = $flatMapped->val();

  expect($sut)->toBe([1, 2, 3, 2, 3, 4, 3, 4, 5]);
});

test('asserts flatMapIndexed behaves correctly', function () {
  $container = ImmutableArray::of([1, 2, 3]);

  $flatMapIndexed = $container->flatMapIndexed(function ($key, $val) {
    return  ["$key $val", "$val $key"];
  });

  $sut = $flatMapIndexed->val();

  expect($sut)->toBe(['0 1', '1 0', '1 2', '2 1', '2 3', '3 2']);
});

test('asserts flatten behaves correctly', function () {
  $container = ImmutableArray::of([1, [2, 3, [4], [5, 6, 7, [8]], [9]]]);

  $sut = $container
    ->flatten()
    ->val();

  expect($sut)->toBe([1, 2, 3, 4, 5, 6, 7, 8, 9]);
});

test('asserts fold behaves correctly', function () {
  $container = ImmutableArray::of([10, 20, 30]);

  $sut = $container->fold(100, function ($acc, $cur) {
    return $acc + $cur;
  });

  expect($sut)->toBe(160);
});

test('asserts foldIndexed behaves correctly', function () {
  $container = ImmutableArray::of([10, 20, 30]);

  $sut = $container->foldIndexed(100, function ($idx, $acc, $cur) {
    return $idx + $acc + $cur;
  });

  expect($sut)->toBe(163);
});

test('asserts foldRight behaves correctly', function () {
  $container = ImmutableArray::of([10, 20, 30]);

  $sut = $container->fold(50, function ($acc, $cur) {
    return $acc - $cur;
  });

  expect($sut)->toBe(-10);
});

test('asserts foldRightIndexed behaves correctly', function () {
  $container = ImmutableArray::of([10, 20, 30]);

  $sut = $container->foldIndexed(50, function ($idx, $acc, $cur) {
    return $acc - $cur - $idx;
  });

  expect($sut)->toBe(-13);
});

test('asserts forEach behaves correctly', function () {
  $container = ImmutableArray::of([10, 20, 30]);

  $sut = [];
  $container->forEach(function ($value) use (&$sut) {
    $sut[] = $value;
  });

  expect($sut)->toBe([10, 20, 30]);
});

test('asserts forEachIndexed behaves correctly', function () {
  $container = ImmutableArray::of([10, 20, 30]);

  $sut = [];
  $container->forEachIndexed(function ($idx, $val) use (&$sut) {
    $sut[] = "Index: $idx | Value: $val";
  });

  expect($sut)->toBe([
    "Index: 0 | Value: 10",
    "Index: 1 | Value: 20",
    "Index: 2 | Value: 30"
  ]);
});

test('asserts get on existing index', function () {
  $container = ImmutableArray::of([10, 20, 30]);

  $sut = $container->get(0);

  expect($sut)->toBe(10);
});

test('asserts get on non-existing index', function () {
  $container = ImmutableArray::of([10, 20, 30]);

  $container->get(10);
})->throws(Exception::class);

test('asserts getOrElse on existing index', function () {
  $container = ImmutableArray::of([10, 20, 30]);

  $sut = $container->getOrElse(0, 'Not found');

  expect($sut)->toBe(10);
});

test('asserts getOrElse on non-existing index', function () {
  $container = ImmutableArray::of([10, 20, 30]);

  $sut = $container->getOrElse(10, 'Not found');

  expect($sut)->toBe('Not found');
});

test('asserts getOrNull on existing index', function () {
  $container = ImmutableArray::of([10, 20, 30]);

  $sut = $container->getOrNull(0);

  expect($sut)->toBe(10);
});

test('asserts getOrNull on non-existing index', function () {
  $container = ImmutableArray::of([10, 20, 30]);

  $sut = $container->getOrNull(10);

  expect($sut)->toBe(null);
});

test('asserts groupBy behaves correctly', function () {
  $container = ImmutableArray::of([10, 20, 30, 100, 120, 150]);

  $grouped = $container->groupBy(function ($value) {
    return $value >= 100 ? 'Hundreds' : 'Tens';
  });

  $sut = $grouped->val();

  expect($sut)->toBe([
    'Tens' => [10, 20, 30],
    'Hundreds' => [100, 120, 150],
  ]);
});
