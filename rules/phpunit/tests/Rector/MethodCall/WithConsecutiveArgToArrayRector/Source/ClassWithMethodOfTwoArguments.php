<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PHPUnit\Tests\Rector\MethodCall\WithConsecutiveArgToArrayRector\Source;

final class ClassWithMethodOfTwoArguments
{
    public function go(int $one, string $two) : void
    {
        $three = $one + $two;
    }
}
