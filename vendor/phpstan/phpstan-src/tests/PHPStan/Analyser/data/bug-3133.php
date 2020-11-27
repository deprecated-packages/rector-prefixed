<?php

namespace _PhpScoper88fe6e0ad041\Bug3133;

use function PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param string[]|string $arg
     */
    public function doFoo($arg) : void
    {
        if (!\is_numeric($arg)) {
            \PHPStan\Analyser\assertType('array<string>|string', $arg);
            return;
        }
        \PHPStan\Analyser\assertType('string&numeric', $arg);
    }
    /**
     * @param string|bool|float|int|mixed[]|null $arg
     */
    public function doBar($arg) : void
    {
        if (\is_numeric($arg)) {
            \PHPStan\Analyser\assertType('float|int|(string&numeric)', $arg);
        }
    }
    /**
     * @param numeric $numeric
     * @param numeric-string $numericString
     */
    public function doBaz($numeric, string $numericString)
    {
        \PHPStan\Analyser\assertType('float|int|(string&numeric)', $numeric);
        \PHPStan\Analyser\assertType('string&numeric', $numericString);
    }
    /**
     * @param numeric-string $numericString
     */
    public function doLorem(string $numericString)
    {
        $a = [];
        $a[$numericString] = 'foo';
        \PHPStan\Analyser\assertType('array<int, \'foo\'>', $a);
    }
}
