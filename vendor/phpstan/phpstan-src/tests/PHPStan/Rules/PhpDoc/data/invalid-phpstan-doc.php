<?php

namespace _PhpScoper26e51eeacccf\InvalidPHPStanDoc;

class Baz
{
}
/** @phpstan-extens Baz */
class Boo extends \_PhpScoper26e51eeacccf\InvalidPHPStanDoc\Baz
{
    /**
     * @phpstan-template T
     * @phpstan-pararm class-string<T> $a
     * @phpstan-return T
     */
    function foo(string $a)
    {
    }
    /**
     * @phpstan-ignore-next-line
     * @phpstan-pararm
     */
    function bar()
    {
    }
    function baz()
    {
        /** @phpstan-va */
        $a = $b;
        /** @phpstan-ignore-line */
        $c = 'foo';
    }
    /**
     * @phpstan-throws void
     */
    function any()
    {
    }
}
