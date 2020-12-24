<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source;

use _PhpScopere8e811afab72\Nette\Application\UI\Control;
final class ExternalControl extends \_PhpScopere8e811afab72\Nette\Application\UI\Control
{
    public function createComponentAnother() : \_PhpScopere8e811afab72\Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source\AnotherControl
    {
        return new \_PhpScopere8e811afab72\Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source\AnotherControl();
    }
}
