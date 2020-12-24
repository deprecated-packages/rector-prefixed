<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Tests\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector\Source;

final class SameNameMethod
{
    public function getName() : \_PhpScoperb75b35f52b74\Rector\Naming\Tests\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector\Source\FullName
    {
        return new \_PhpScoperb75b35f52b74\Rector\Naming\Tests\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector\Source\FullName();
    }
}
