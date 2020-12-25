<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source;

use _PhpScoper50d83356d739\Nette\Application\UI\Control;
final class ExternalControl extends \_PhpScoper50d83356d739\Nette\Application\UI\Control
{
    public function createComponentAnother() : \Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source\AnotherControl
    {
        return new \Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source\AnotherControl();
    }
}
