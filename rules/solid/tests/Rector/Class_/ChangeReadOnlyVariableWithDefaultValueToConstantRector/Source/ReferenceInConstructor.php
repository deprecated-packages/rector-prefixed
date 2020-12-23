<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\SOLID\Tests\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector\Source;

final class ReferenceInConstructor
{
    public function __construct(string &$value)
    {
    }
}
