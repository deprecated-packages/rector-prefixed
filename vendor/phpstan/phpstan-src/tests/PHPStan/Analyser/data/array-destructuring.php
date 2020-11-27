<?php

namespace _PhpScopera143bcca66cb;

function () {
    /** @var mixed $array */
    $array = \_PhpScopera143bcca66cb\getMixed();
    [$a, $b, [$c]] = $array;
    list($aList, $bList, list($cList)) = $array;
    $constantArray = [1, 'foo', [\true]];
    [$int, $string, [$bool, $nestedNever], $never] = $constantArray;
    list($intList, $stringList, list($boolList, $nestedNeverList), $neverList) = $constantArray;
    $unionArray = $foo ? [1, 2, 3] : [4, 'bar'];
    [$u1, $u2, $u3] = $unionArray;
    foreach ([[1, [\false]]] as [$foreachInt, [$foreachBool, $foreachNestedNever], $foreachNever]) {
    }
    foreach ([[1, [\false]]] as list($foreachIntList, list($foreachBoolList, $foreachNestedNeverList), $foreachNeverList)) {
    }
    foreach ([$unionArray] as [$foreachU1, $foreachU2, $foreachU3]) {
    }
    /** @var string[] $stringArray */
    $stringArray = \_PhpScopera143bcca66cb\getStringArray();
    [$firstStringArray, $secondStringArray, [$thirdStringArray], $fourthStringArray] = $stringArray;
    list($firstStringArrayList, $secondStringArrayList, list($thirdStringArrayList), $fourthStringArrayList) = $stringArray;
    foreach ($stringArray as [$firstStringArrayForeach, $secondStringArrayForeach, [$thirdStringArrayForeach], $fourthStringArrayForeach]) {
    }
    foreach ($stringArray as list($firstStringArrayForeachList, $secondStringArrayForeachList, list($thirdStringArrayForeachList), $fourthStringArrayForeachList)) {
    }
    /** @var int $dayInt */
    $dayInt = \_PhpScopera143bcca66cb\getInt($dayInt);
    $dateArray = ['d' => $dayInt];
    [$dateArray['Y'], $dateArray['m']] = \explode('-', '2018-12-19');
    /** @var int $firstIntElement */
    $firstIntElement = \_PhpScopera143bcca66cb\getInt();
    /** @var int $secondIntElement */
    $secondIntElement = \_PhpScopera143bcca66cb\getInt();
    $intArrayForRewritingFirstElement = [$firstIntElement, $secondIntElement];
    [$intArrayForRewritingFirstElement[0]] = \explode('*', '');
    [$newArray['newKey']] = [new \stdClass(), new \stdClass()];
    $obj = new \stdClass();
    [$obj[0]] = ['error', 'error-error'];
    $constantAssocArray = [1, 'foo', 'key' => \true, 'value' => '123'];
    ['key' => $assocKey, 0 => $assocOne, 1 => $assocFoo, 'non-existent' => $assocNonExistent] = $constantAssocArray;
    $fooKey = 'key';
    /** @var string $stringKey */
    $stringKey = \_PhpScopera143bcca66cb\getString();
    /** @var mixed $mixedKey */
    $mixedKey = \_PhpScopera143bcca66cb\getMixed();
    [$fooKey => $dynamicAssocKey, $stringKey => $dynamicAssocStrings, $mixedKey => $dynamicAssocMixed] = $constantAssocArray;
    foreach ([$constantAssocArray] as [$fooKey => $dynamicAssocKeyForeach, $stringKey => $dynamicAssocStringsForeach, $mixedKey => $dynamicAssocMixedForeach]) {
    }
    /** @var iterable<array<string>> $iterableOverStringArrays */
    $iterableOverStringArrays = \_PhpScopera143bcca66cb\doFoo();
    foreach ($iterableOverStringArrays as [$stringFromIterable]) {
    }
    /** @var string $stringWithVarAnnotation  */
    [$stringWithVarAnnotation] = \_PhpScopera143bcca66cb\doFoo();
    /** @var string $stringWithVarAnnotationInForeach */
    foreach (\_PhpScopera143bcca66cb\doFoo() as [$stringWithVarAnnotationInForeach]) {
    }
    die;
};
