<?php

namespace _PhpScoper88fe6e0ad041\ExplodeFunction;

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
