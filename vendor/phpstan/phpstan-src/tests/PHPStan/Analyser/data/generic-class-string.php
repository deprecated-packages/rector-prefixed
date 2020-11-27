<?php

namespace PHPStan\Generics\GenericClassStringType;

use function PHPStan\Analyser\assertType;
class C
{
    public static function f() : int
    {
        return 0;
    }
}
/**
 * @param mixed $a
 */
function testMixed($a)
{
    \PHPStan\Analyser\assertType('mixed', new $a());
    if (\is_subclass_of($a, 'DateTimeInterface')) {
        \PHPStan\Analyser\assertType('class-string<DateTimeInterface>|DateTimeInterface', $a);
        \PHPStan\Analyser\assertType('DateTimeInterface', new $a());
    }
    if (\is_subclass_of($a, 'DateTimeInterface') || \is_subclass_of($a, 'stdClass')) {
        \PHPStan\Analyser\assertType('class-string<DateTimeInterface>|class-string<stdClass>|DateTimeInterface|stdClass', $a);
        \PHPStan\Analyser\assertType('DateTimeInterface|stdClass', new $a());
    }
    if (\is_subclass_of($a, \PHPStan\Generics\GenericClassStringType\C::class)) {
        \PHPStan\Analyser\assertType('int', $a::f());
    }
}
/**
 * @param object $a
 */
function testObject($a)
{
    \PHPStan\Analyser\assertType('mixed', new $a());
    if (\is_subclass_of($a, 'DateTimeInterface')) {
        \PHPStan\Analyser\assertType('DateTimeInterface', $a);
    }
}
/**
 * @param string $a
 */
function testString($a)
{
    \PHPStan\Analyser\assertType('mixed', new $a());
    if (\is_subclass_of($a, 'DateTimeInterface')) {
        \PHPStan\Analyser\assertType('class-string<DateTimeInterface>', $a);
        \PHPStan\Analyser\assertType('DateTimeInterface', new $a());
    }
    if (\is_subclass_of($a, \PHPStan\Generics\GenericClassStringType\C::class)) {
        \PHPStan\Analyser\assertType('int', $a::f());
    }
}
/**
 * @param string|object $a
 */
function testStringObject($a)
{
    \PHPStan\Analyser\assertType('mixed', new $a());
    if (\is_subclass_of($a, 'DateTimeInterface')) {
        \PHPStan\Analyser\assertType('class-string<DateTimeInterface>|DateTimeInterface', $a);
        \PHPStan\Analyser\assertType('DateTimeInterface', new $a());
    }
    if (\is_subclass_of($a, \PHPStan\Generics\GenericClassStringType\C::class)) {
        \PHPStan\Analyser\assertType('int', $a::f());
    }
}
/**
 * @param class-string<\DateTimeInterface> $a
 */
function testClassString($a)
{
    \PHPStan\Analyser\assertType('DateTimeInterface', new $a());
    if (\is_subclass_of($a, 'DateTime')) {
        \PHPStan\Analyser\assertType('class-string<DateTime>', $a);
        \PHPStan\Analyser\assertType('DateTime', new $a());
    }
}
function testClassExists(string $str)
{
    \PHPStan\Analyser\assertType('string', $str);
    if (\class_exists($str)) {
        \PHPStan\Analyser\assertType('class-string', $str);
    }
    $existentClass = \stdClass::class;
    if (\class_exists($existentClass)) {
        \PHPStan\Analyser\assertType('\'stdClass\'', $existentClass);
    }
    $nonexistentClass = 'NonexistentClass';
    if (\class_exists($nonexistentClass)) {
        \PHPStan\Analyser\assertType('\'NonexistentClass\'', $nonexistentClass);
    }
}
function testInterfaceExists(string $str)
{
    \PHPStan\Analyser\assertType('string', $str);
    if (\interface_exists($str)) {
        \PHPStan\Analyser\assertType('class-string', $str);
    }
}
function testTraitExists(string $str)
{
    \PHPStan\Analyser\assertType('string', $str);
    if (\trait_exists($str)) {
        \PHPStan\Analyser\assertType('class-string', $str);
    }
}
