<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\Tests\Rector\MethodCall\WithConsecutiveArgToArrayRector\Source;

final class ClassWithMethodOfTwoArguments
{
    public function go(int $one, string $two) : void
    {
        $three = $one + $two;
    }
}
