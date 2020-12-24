<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\SOLID\Tests\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector\Source;

final class ReferenceInConstructor
{
    public function __construct(string &$value)
    {
    }
}
