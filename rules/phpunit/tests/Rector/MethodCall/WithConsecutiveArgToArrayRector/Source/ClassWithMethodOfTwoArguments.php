<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\Tests\Rector\MethodCall\WithConsecutiveArgToArrayRector\Source;

final class ClassWithMethodOfTwoArguments
{
    public function go(int $one, string $two) : void
    {
        $three = $one + $two;
    }
}
