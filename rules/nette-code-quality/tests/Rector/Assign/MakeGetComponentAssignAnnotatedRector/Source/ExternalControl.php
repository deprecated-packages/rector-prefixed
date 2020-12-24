<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source;

use _PhpScoperb75b35f52b74\Nette\Application\UI\Control;
final class ExternalControl extends \_PhpScoperb75b35f52b74\Nette\Application\UI\Control
{
    public function createComponentAnother() : \_PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source\AnotherControl
    {
        return new \_PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source\AnotherControl();
    }
}
