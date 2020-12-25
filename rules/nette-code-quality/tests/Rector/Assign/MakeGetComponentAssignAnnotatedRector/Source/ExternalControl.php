<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source;

use _PhpScoper8b9c402c5f32\Nette\Application\UI\Control;
final class ExternalControl extends \_PhpScoper8b9c402c5f32\Nette\Application\UI\Control
{
    public function createComponentAnother() : \Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source\AnotherControl
    {
        return new \Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source\AnotherControl();
    }
}
