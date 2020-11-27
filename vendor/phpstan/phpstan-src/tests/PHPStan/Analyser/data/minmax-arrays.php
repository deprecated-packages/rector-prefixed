<?php

namespace _PhpScoperbd5d0c5f7638\MinMaxArrays;

use function PHPStan\Analyser\assertType;
function dummy() : void
{
    \PHPStan\Analyser\assertType('1', \min([1]));
    \PHPStan\Analyser\assertType('false', \min([]));
    \PHPStan\Analyser\assertType('1', \max([1]));
    \PHPStan\Analyser\assertType('false', \max([]));
}
/**
 * @param int[] $ints
 */
function dummy2(array $ints) : void
{
    if (\count($ints) === 0) {
        \PHPStan\Analyser\assertType('false', \min($ints));
        \PHPStan\Analyser\assertType('false', \max($ints));
    } else {
        \PHPStan\Analyser\assertType('int', \min($ints));
        \PHPStan\Analyser\assertType('int', \max($ints));
    }
    if (\count($ints) === 1) {
        \PHPStan\Analyser\assertType('int', \min($ints));
        \PHPStan\Analyser\assertType('int', \max($ints));
    } else {
        \PHPStan\Analyser\assertType('int|false', \min($ints));
        \PHPStan\Analyser\assertType('int|false', \max($ints));
    }
    if (\count($ints) !== 0) {
        \PHPStan\Analyser\assertType('int', \min($ints));
        \PHPStan\Analyser\assertType('int', \max($ints));
    } else {
        \PHPStan\Analyser\assertType('false', \min($ints));
        \PHPStan\Analyser\assertType('false', \max($ints));
    }
    if (\count($ints) !== 1) {
        \PHPStan\Analyser\assertType('int|false', \min($ints));
        \PHPStan\Analyser\assertType('int|false', \max($ints));
    } else {
        \PHPStan\Analyser\assertType('int', \min($ints));
        \PHPStan\Analyser\assertType('int', \max($ints));
    }
    if (\count($ints) > 0) {
        \PHPStan\Analyser\assertType('int', \min($ints));
        \PHPStan\Analyser\assertType('int', \max($ints));
    } else {
        \PHPStan\Analyser\assertType('false', \min($ints));
        \PHPStan\Analyser\assertType('false', \max($ints));
    }
    if (\count($ints) >= 1) {
        \PHPStan\Analyser\assertType('int', \min($ints));
        \PHPStan\Analyser\assertType('int', \max($ints));
    } else {
        \PHPStan\Analyser\assertType('false', \min($ints));
        \PHPStan\Analyser\assertType('false', \max($ints));
    }
    if (\count($ints) >= 2) {
        \PHPStan\Analyser\assertType('int', \min($ints));
        \PHPStan\Analyser\assertType('int', \max($ints));
    } else {
        \PHPStan\Analyser\assertType('int|false', \min($ints));
        \PHPStan\Analyser\assertType('int|false', \max($ints));
    }
    if (\count($ints) <= 0) {
        \PHPStan\Analyser\assertType('false', \min($ints));
        \PHPStan\Analyser\assertType('false', \max($ints));
    } else {
        \PHPStan\Analyser\assertType('int', \min($ints));
        \PHPStan\Analyser\assertType('int', \max($ints));
    }
    if (\count($ints) < 1) {
        \PHPStan\Analyser\assertType('false', \min($ints));
        \PHPStan\Analyser\assertType('false', \max($ints));
    } else {
        \PHPStan\Analyser\assertType('int', \min($ints));
        \PHPStan\Analyser\assertType('int', \max($ints));
    }
    if (\count($ints) < 2) {
        \PHPStan\Analyser\assertType('int|false', \min($ints));
        \PHPStan\Analyser\assertType('int|false', \max($ints));
    } else {
        \PHPStan\Analyser\assertType('int', \min($ints));
        \PHPStan\Analyser\assertType('int', \max($ints));
    }
}
/**
 * @param int[] $ints
 */
function dummy3(array $ints) : void
{
    \PHPStan\Analyser\assertType('int|false', \min($ints));
    \PHPStan\Analyser\assertType('int|false', \max($ints));
}
function dummy4(\DateTimeInterface $dateA, ?\DateTimeInterface $dateB) : void
{
    \PHPStan\Analyser\assertType('array(0 => DateTimeInterface, ?1 => DateTimeInterface)', \array_filter([$dateA, $dateB]));
    \PHPStan\Analyser\assertType('DateTimeInterface', \min(\array_filter([$dateA, $dateB])));
    \PHPStan\Analyser\assertType('DateTimeInterface', \max(\array_filter([$dateA, $dateB])));
    \PHPStan\Analyser\assertType('array(?0 => DateTimeInterface)', \array_filter([$dateB]));
    \PHPStan\Analyser\assertType('DateTimeInterface|false', \min(\array_filter([$dateB])));
    \PHPStan\Analyser\assertType('DateTimeInterface|false', \max(\array_filter([$dateB])));
}
function dummy5(int $i, int $j) : void
{
    \PHPStan\Analyser\assertType('array(?0 => int<min, -1>|int<1, max>, ?1 => int<min, -1>|int<1, max>)', \array_filter([$i, $j]));
    \PHPStan\Analyser\assertType('array(1 => true)', \array_filter([\false, \true]));
}
function dummy6(string $s, string $t) : void
{
    \PHPStan\Analyser\assertType('array(?0 => string, ?1 => string)', \array_filter([$s, $t]));
}
