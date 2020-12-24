<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source;

use _PhpScoper0a6b37af0871\Nette\Application\UI\Control;
final class ExternalControl extends \_PhpScoper0a6b37af0871\Nette\Application\UI\Control
{
    public function createComponentAnother() : \_PhpScoper0a6b37af0871\Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source\AnotherControl
    {
        return new \_PhpScoper0a6b37af0871\Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source\AnotherControl();
    }
}
