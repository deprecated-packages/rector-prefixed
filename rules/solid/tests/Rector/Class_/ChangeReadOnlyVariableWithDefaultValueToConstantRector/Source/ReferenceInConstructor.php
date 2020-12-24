<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\SOLID\Tests\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector\Source;

final class ReferenceInConstructor
{
    public function __construct(string &$value)
    {
    }
}
