<?php

namespace _PhpScoper006a73f0e455\IncDecInConditions;

use function PHPStan\Analyser\assertType;
function incLeft(int $a, int $b, int $c, int $d) : void
{
    if (++$a < 0) {
        \PHPStan\Analyser\assertType('int<min, -1>', $a);
    } else {
        \PHPStan\Analyser\assertType('int<0, max>', $a);
    }
    if (++$b <= 0) {
        \PHPStan\Analyser\assertType('int<min, 0>', $b);
    } else {
        \PHPStan\Analyser\assertType('int<1, max>', $b);
    }
    if ($c++ < 0) {
        \PHPStan\Analyser\assertType('int<min, 0>', $c);
    } else {
        \PHPStan\Analyser\assertType('int<1, max>', $c);
    }
    if ($d++ <= 0) {
        \PHPStan\Analyser\assertType('int<min, 1>', $d);
    } else {
        \PHPStan\Analyser\assertType('int<2, max>', $d);
    }
}
function incRight(int $a, int $b, int $c, int $d) : void
{
    if (0 < ++$a) {
        \PHPStan\Analyser\assertType('int<1, max>', $a);
    } else {
        \PHPStan\Analyser\assertType('int<min, 0>', $a);
    }
    if (0 <= ++$b) {
        \PHPStan\Analyser\assertType('int<0, max>', $b);
    } else {
        \PHPStan\Analyser\assertType('int<min, -1>', $b);
    }
    if (0 < $c++) {
        \PHPStan\Analyser\assertType('int<2, max>', $c);
    } else {
        \PHPStan\Analyser\assertType('int<min, 1>', $c);
    }
    if (0 <= $d++) {
        \PHPStan\Analyser\assertType('int<1, max>', $d);
    } else {
        \PHPStan\Analyser\assertType('int<min, 0>', $d);
    }
}
function decLeft(int $a, int $b, int $c, int $d) : void
{
    if (--$a < 0) {
        \PHPStan\Analyser\assertType('int<min, -1>', $a);
    } else {
        \PHPStan\Analyser\assertType('int<0, max>', $a);
    }
    if (--$b <= 0) {
        \PHPStan\Analyser\assertType('int<min, 0>', $b);
    } else {
        \PHPStan\Analyser\assertType('int<1, max>', $b);
    }
    if ($c-- < 0) {
        \PHPStan\Analyser\assertType('int<min, -2>', $c);
    } else {
        \PHPStan\Analyser\assertType('int<-1, max>', $c);
    }
    if ($d-- <= 0) {
        \PHPStan\Analyser\assertType('int<min, -1>', $d);
    } else {
        \PHPStan\Analyser\assertType('int<0, max>', $d);
    }
}
function decRight(int $a, int $b, int $c, int $d) : void
{
    if (0 < --$a) {
        \PHPStan\Analyser\assertType('int<1, max>', $a);
    } else {
        \PHPStan\Analyser\assertType('int<min, 0>', $a);
    }
    if (0 <= --$b) {
        \PHPStan\Analyser\assertType('int<0, max>', $b);
    } else {
        \PHPStan\Analyser\assertType('int<min, -1>', $b);
    }
    if (0 < $c--) {
        \PHPStan\Analyser\assertType('int<0, max>', $c);
    } else {
        \PHPStan\Analyser\assertType('int<min, -1>', $c);
    }
    if (0 <= $d--) {
        \PHPStan\Analyser\assertType('int<-1, max>', $d);
    } else {
        \PHPStan\Analyser\assertType('int<min, -2>', $d);
    }
}
