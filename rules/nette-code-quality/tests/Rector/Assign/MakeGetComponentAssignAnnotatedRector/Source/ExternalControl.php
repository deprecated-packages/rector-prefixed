<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source;

use _PhpScoper0a2ac50786fa\Nette\Application\UI\Control;
final class ExternalControl extends \_PhpScoper0a2ac50786fa\Nette\Application\UI\Control
{
    public function createComponentAnother() : \_PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source\AnotherControl
    {
        return new \_PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source\AnotherControl();
    }
}
