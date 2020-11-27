<?php

namespace _PhpScoper006a73f0e455\ExplodeFunction;

function (string $delimiter, $mixed) {
    /** @var string $str */
    $str = doFoo();
    $sureArray = \explode(' ', $str);
    $sureFalse = \explode('', $str);
    $arrayOrFalse = \explode($delimiter, $str);
    $emptyOrComma = '';
    if (doFoo()) {
        $emptyOrComma = ',';
    }
    $anotherArrayOrFalse = \explode($emptyOrComma, $str);
    $benevolentArrayOrFalse = \explode($mixed, $str);
    die;
};
