<?php

namespace _PhpScoper26e51eeacccf;

$integers = [1, 2, 3];
$mixedValues = ['abc', 123];
$mappedStrings = \array_map(function () : string {
}, $integers);
$filteredIntegers = \array_filter($integers, function () : bool {
});
$filteredMixed = \array_filter($mixedValues, function ($mixedValue) : bool {
    return \is_int($mixedValue);
});
$uniquedIntegers = \array_unique($integers);
$reducedIntegersToString = \array_reduce($integers, function () : string {
});
$reducedIntegersToStringWithNull = \array_reduce($uniquedIntegers, function () : string {
});
$reducedIntegersToStringAnother = \array_reduce($integers, function () : string {
}, 'initial');
$reducedToNull = \array_reduce([], function () : string {
});
$reducedToInt = \array_reduce([], function () : string {
}, 1);
$reducedIntegersToStringWithInt = \array_reduce($uniquedIntegers, function () : string {
}, 1);
$reversedIntegers = \array_reverse($integers);
$filledIntegers = \array_fill(0, 5, 1);
$filledIntegersWithKeys = \array_fill_keys([0], 1);
$integerKeys = [1 => 'foo', 2 => new \stdClass()];
$stringKeys = ['foo' => 'foo', 'bar' => new \stdClass()];
/** @var \stdClass[] $stdClassesWithIsset */
$stdClassesWithIsset = \_PhpScoper26e51eeacccf\doFoo();
if (\rand(0, 1) === 0) {
    $stdClassesWithIsset[] = new \stdClass();
}
if (!isset($stdClassesWithIsset['baz'])) {
    return;
}
$stringOrIntegerKeys = ['foo' => new \stdClass(), 1 => new \stdClass()];
$constantArrayWithFalseyValues = [null, '', 1];
$constantTruthyValues = \array_filter($constantArrayWithFalseyValues);
/** @var array<int, false|null> $falsey */
$falsey = \_PhpScoper26e51eeacccf\doFoo();
/** @var array<int, bool|null> $withFalsey */
$withFalsey = \_PhpScoper26e51eeacccf\doFoo();
$union = ['a' => 1];
if (\rand(0, 1) === 1) {
    $union['b'] = \false;
}
/** @var bool $bool */
$bool = \_PhpScoper26e51eeacccf\doFoo();
/** @var int $integer */
$integer = \_PhpScoper26e51eeacccf\doFoo();
$withPossiblyFalsey = [$bool, $integer, '', 'a' => 0];
/** @var array<string, int> $generalStringKeys */
$generalStringKeys = \_PhpScoper26e51eeacccf\doFoo();
/** @var array<int, int> $generalIntegerKeys */
$generalIntegerKeys = \_PhpScoper26e51eeacccf\doFoo();
/** @var array<int, \DateTimeImmutable> $generalDateTimeValues */
$generalDateTimeValues = \_PhpScoper26e51eeacccf\doFoo();
/** @var int $integer */
$integer = \_PhpScoper26e51eeacccf\doFoo();
/** @var string $string */
$string = \_PhpScoper26e51eeacccf\doFoo();
/** @var int[] $generalIntegers */
$generalIntegers = \_PhpScoper26e51eeacccf\doFoo();
/** @var int[][] $generalIntegersInAnotherArray */
$generalIntegersInAnotherArray = \_PhpScoper26e51eeacccf\doFoo();
$mappedStringKeys = \array_map(function () : \stdClass {
}, $generalStringKeys);
/** @var callable $callable */
$callable = \_PhpScoper26e51eeacccf\doFoo();
$mappedStringKeysWithUnknownClosureType = \array_map($callable, $generalStringKeys);
$mappedWrongArray = \array_map(function () : string {
}, 1);
$unknownArray = \array_map($callable, 1);
$conditionalArray = ['foo', 'bar'];
$conditionalKeysArray = ['foo' => 1, 'bar' => 1];
if (\_PhpScoper26e51eeacccf\doFoo()) {
    $conditionalArray[] = 'baz';
    $conditionalArray[] = 'lorem';
    $conditionalKeysArray['baz'] = 1;
    $conditionalKeysArray['lorem'] = 1;
}
/** @var int|string $generalIntegerOrString */
$generalIntegerOrString = \_PhpScoper26e51eeacccf\doFoo();
/** @var array<int, int|string> $generalArrayOfIntegersOrStrings */
$generalArrayOfIntegersOrStrings = \_PhpScoper26e51eeacccf\doFoo();
/** @var array<int|string, int> $generalIntegerOrStringKeys */
$generalIntegerOrStringKeys = \_PhpScoper26e51eeacccf\doFoo();
/** @var array<int|string, mixed> $generalIntegerOrStringKeysMixedValues */
$generalIntegerOrStringKeysMixedValues = \_PhpScoper26e51eeacccf\doFoo();
$clonedConditionalArray = $conditionalArray;
$clonedConditionalArray[(int) $generalIntegerOrString] = $generalIntegerOrString;
if (\random_int(0, 1)) {
    $unionArrays = [1 => 1, 2 => '', 'a' => 0];
} else {
    $unionArrays = ['foo' => 'bar', 'baz' => 'qux'];
}
/** @var mixed $mixed */
$mixed = \_PhpScoper26e51eeacccf\doFoo();
/** @var array $array */
$array = \_PhpScoper26e51eeacccf\doFoo();
$slicedOffset = \array_slice(['4' => 'foo', 1 => 'bar', 'baz' => 'qux', 0 => 'quux', 'quuz' => 'corge'], 0, null, \false);
$slicedOffsetWithKeys = \array_slice(['4' => 'foo', 1 => 'bar', 'baz' => 'qux', 0 => 'quux', 'quuz' => 'corge'], 0, null, \true);
$slicedOffset[] = 'grault';
$slicedOffsetWithKeys[] = 'grault';
$mergedInts = [];
foreach ($array as $val) {
    $mergedInts = \array_merge($mergedInts, $generalIntegers);
}
$fooArray = ['foo'];
$poppedFoo = \array_pop($fooArray);
die;
