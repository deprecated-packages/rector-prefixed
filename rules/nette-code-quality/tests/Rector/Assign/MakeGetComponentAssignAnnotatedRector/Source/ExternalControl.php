<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source;

use _PhpScoperbf340cb0be9d\Nette\Application\UI\Control;
final class ExternalControl extends \_PhpScoperbf340cb0be9d\Nette\Application\UI\Control
{
    public function createComponentAnother() : \Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source\AnotherControl
    {
        return new \Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source\AnotherControl();
    }
}
