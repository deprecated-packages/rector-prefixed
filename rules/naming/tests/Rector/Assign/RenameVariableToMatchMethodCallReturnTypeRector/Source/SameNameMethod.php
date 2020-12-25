<?php

declare (strict_types=1);
namespace Rector\Naming\Tests\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector\Source;

final class SameNameMethod
{
    public function getName() : \Rector\Naming\Tests\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector\Source\FullName
    {
        return new \Rector\Naming\Tests\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector\Source\FullName();
    }
}
