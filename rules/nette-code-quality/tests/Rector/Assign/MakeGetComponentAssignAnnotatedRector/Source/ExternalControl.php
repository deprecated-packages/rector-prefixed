<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source;

use _PhpScoper2a4e7ab1ecbc\Nette\Application\UI\Control;
final class ExternalControl extends \_PhpScoper2a4e7ab1ecbc\Nette\Application\UI\Control
{
    public function createComponentAnother() : \_PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source\AnotherControl
    {
        return new \_PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source\AnotherControl();
    }
}
