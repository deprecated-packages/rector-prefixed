<?php

declare (strict_types=1);
namespace Rector\Tests\NetteCodeQuality\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source;

use RectorPrefix20210320\Nette\Application\UI\Control;
final class ExternalControl extends \RectorPrefix20210320\Nette\Application\UI\Control
{
    public function createComponentAnother() : \Rector\Tests\NetteCodeQuality\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source\AnotherControl
    {
        return new \Rector\Tests\NetteCodeQuality\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source\AnotherControl();
    }
}
