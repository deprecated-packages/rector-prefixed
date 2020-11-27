<?php

namespace _PhpScoperbd5d0c5f7638\NativeTypes;

use function PHPStan\Analyser\assertType;
use function PHPStan\Analyser\assertNativeType;
class Foo
{
    /**
     * @param self $foo
     * @param \DateTimeImmutable $dateTime
     * @param \DateTimeImmutable $dateTimeMutable
     * @param string $nullableString
     * @param string|null $nonNullableString
     */
    public function doFoo($foo, \DateTimeInterface $dateTime, \DateTime $dateTimeMutable, ?string $nullableString, string $nonNullableString) : void
    {
        \PHPStan\Analyser\assertType(\_PhpScoperbd5d0c5f7638\NativeTypes\Foo::class, $foo);
        \PHPStan\Analyser\assertNativeType('mixed', $foo);
        // change type after assignment
        $foo = new \_PhpScoperbd5d0c5f7638\NativeTypes\Foo();
        \PHPStan\Analyser\assertType(\_PhpScoperbd5d0c5f7638\NativeTypes\Foo::class, $foo);
        \PHPStan\Analyser\assertNativeType(\_PhpScoperbd5d0c5f7638\NativeTypes\Foo::class, $foo);
        \PHPStan\Analyser\assertType(\DateTimeImmutable::class, $dateTime);
        \PHPStan\Analyser\assertNativeType(\DateTimeInterface::class, $dateTime);
        $f = function (\_PhpScoperbd5d0c5f7638\NativeTypes\Foo $foo) use($dateTime) {
            \PHPStan\Analyser\assertType(\_PhpScoperbd5d0c5f7638\NativeTypes\Foo::class, $foo);
            \PHPStan\Analyser\assertNativeType(\_PhpScoperbd5d0c5f7638\NativeTypes\Foo::class, $foo);
            \PHPStan\Analyser\assertType(\DateTimeImmutable::class, $dateTime);
            \PHPStan\Analyser\assertNativeType(\DateTimeInterface::class, $dateTime);
        };
        \PHPStan\Analyser\assertType(\DateTime::class, $dateTimeMutable);
        \PHPStan\Analyser\assertNativeType(\DateTime::class, $dateTimeMutable);
        \PHPStan\Analyser\assertType('string|null', $nullableString);
        \PHPStan\Analyser\assertNativeType('string|null', $nullableString);
        if (\is_string($nullableString)) {
            // change specified type
            \PHPStan\Analyser\assertType('string', $nullableString);
            \PHPStan\Analyser\assertNativeType('string', $nullableString);
            // preserve other variables
            \PHPStan\Analyser\assertType(\DateTimeImmutable::class, $dateTime);
            \PHPStan\Analyser\assertNativeType(\DateTimeInterface::class, $dateTime);
        }
        // preserve after merging scopes
        \PHPStan\Analyser\assertType(\DateTimeImmutable::class, $dateTime);
        \PHPStan\Analyser\assertNativeType(\DateTimeInterface::class, $dateTime);
        \PHPStan\Analyser\assertType('string', $nonNullableString);
        \PHPStan\Analyser\assertNativeType('string', $nonNullableString);
        unset($nonNullableString);
        \PHPStan\Analyser\assertType('*ERROR*', $nonNullableString);
        \PHPStan\Analyser\assertNativeType('*ERROR*', $nonNullableString);
        // preserve other variables
        \PHPStan\Analyser\assertType(\DateTimeImmutable::class, $dateTime);
        \PHPStan\Analyser\assertNativeType(\DateTimeInterface::class, $dateTime);
    }
    /**
     * @param array<string, int> $array
     */
    public function doForeach(array $array) : void
    {
        \PHPStan\Analyser\assertType('array<string, int>', $array);
        \PHPStan\Analyser\assertNativeType('array', $array);
        foreach ($array as $key => $value) {
            \PHPStan\Analyser\assertType('array<string, int>', $array);
            \PHPStan\Analyser\assertNativeType('array', $array);
            \PHPStan\Analyser\assertType('string', $key);
            \PHPStan\Analyser\assertNativeType('(int|string)', $key);
            \PHPStan\Analyser\assertType('int', $value);
            \PHPStan\Analyser\assertNativeType('mixed', $value);
        }
    }
    /**
     * @param self $foo
     */
    public function doCatch($foo) : void
    {
        \PHPStan\Analyser\assertType(\_PhpScoperbd5d0c5f7638\NativeTypes\Foo::class, $foo);
        \PHPStan\Analyser\assertNativeType('mixed', $foo);
        try {
            throw new \Exception();
        } catch (\InvalidArgumentException $foo) {
            \PHPStan\Analyser\assertType(\InvalidArgumentException::class, $foo);
            \PHPStan\Analyser\assertNativeType(\InvalidArgumentException::class, $foo);
        } catch (\Exception $e) {
            \PHPStan\Analyser\assertType(\Exception::class, $e);
            \PHPStan\Analyser\assertNativeType(\Exception::class, $e);
            \PHPStan\Analyser\assertType(\_PhpScoperbd5d0c5f7638\NativeTypes\Foo::class, $foo);
            \PHPStan\Analyser\assertNativeType('mixed', $foo);
        }
    }
    /**
     * @param array<string, array{int, string}> $array
     */
    public function doForeachArrayDestructuring(array $array)
    {
        \PHPStan\Analyser\assertType('array<string, array(int, string)>', $array);
        \PHPStan\Analyser\assertNativeType('array', $array);
        foreach ($array as $key => [$i, $s]) {
            \PHPStan\Analyser\assertType('array<string, array(int, string)>', $array);
            \PHPStan\Analyser\assertNativeType('array', $array);
            \PHPStan\Analyser\assertType('string', $key);
            \PHPStan\Analyser\assertNativeType('(int|string)', $key);
            \PHPStan\Analyser\assertType('int', $i);
            // assertNativeType('mixed', $i);
            \PHPStan\Analyser\assertType('string', $s);
            // assertNativeType('mixed', $s);
        }
    }
    /**
     * @param \DateTimeImmutable $date
     */
    public function doIfElse(\DateTimeInterface $date) : void
    {
        if ($date instanceof \DateTimeInterface) {
            \PHPStan\Analyser\assertType(\DateTimeImmutable::class, $date);
            \PHPStan\Analyser\assertNativeType(\DateTimeInterface::class, $date);
        } else {
            \PHPStan\Analyser\assertType('*NEVER*', $date);
            \PHPStan\Analyser\assertNativeType('*NEVER*', $date);
        }
        \PHPStan\Analyser\assertType(\DateTimeImmutable::class, $date);
        \PHPStan\Analyser\assertNativeType(\DateTimeInterface::class, $date);
        if ($date instanceof \DateTimeImmutable) {
            \PHPStan\Analyser\assertType(\DateTimeImmutable::class, $date);
            \PHPStan\Analyser\assertNativeType(\DateTimeImmutable::class, $date);
        } else {
            \PHPStan\Analyser\assertType('*NEVER*', $date);
            \PHPStan\Analyser\assertNativeType('DateTimeInterface~DateTimeImmutable', $date);
        }
        \PHPStan\Analyser\assertType(\DateTimeImmutable::class, $date);
        \PHPStan\Analyser\assertNativeType(\DateTimeImmutable::class, $date);
        // could be DateTimeInterface
        if ($date instanceof \DateTime) {
        }
    }
}
/**
 * @param Foo $foo
 * @param \DateTimeImmutable $dateTime
 * @param \DateTimeImmutable $dateTimeMutable
 * @param string $nullableString
 * @param string|null $nonNullableString
 */
function fooFunction($foo, \DateTimeInterface $dateTime, \DateTime $dateTimeMutable, ?string $nullableString, string $nonNullableString) : void
{
    \PHPStan\Analyser\assertType(\_PhpScoperbd5d0c5f7638\NativeTypes\Foo::class, $foo);
    \PHPStan\Analyser\assertNativeType('mixed', $foo);
    \PHPStan\Analyser\assertType(\DateTimeImmutable::class, $dateTime);
    \PHPStan\Analyser\assertNativeType(\DateTimeInterface::class, $dateTime);
    \PHPStan\Analyser\assertType(\DateTime::class, $dateTimeMutable);
    \PHPStan\Analyser\assertNativeType(\DateTime::class, $dateTimeMutable);
    \PHPStan\Analyser\assertType('string|null', $nullableString);
    \PHPStan\Analyser\assertNativeType('string|null', $nullableString);
    \PHPStan\Analyser\assertType('string', $nonNullableString);
    \PHPStan\Analyser\assertNativeType('string', $nonNullableString);
}
