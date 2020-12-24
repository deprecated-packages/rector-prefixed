<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Naming\Tests\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector\Source;

final class SameNameMethod
{
    public function getName() : \_PhpScoper2a4e7ab1ecbc\Rector\Naming\Tests\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector\Source\FullName
    {
        return new \_PhpScoper2a4e7ab1ecbc\Rector\Naming\Tests\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector\Source\FullName();
    }
}
