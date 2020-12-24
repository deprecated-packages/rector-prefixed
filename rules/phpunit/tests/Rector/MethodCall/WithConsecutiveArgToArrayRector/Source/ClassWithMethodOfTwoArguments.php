<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\Tests\Rector\MethodCall\WithConsecutiveArgToArrayRector\Source;

final class ClassWithMethodOfTwoArguments
{
    public function go(int $one, string $two) : void
    {
        $three = $one + $two;
    }
}
