<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source;

use RectorPrefix2020DecSat\Nette\Application\UI\Control;
final class ExternalControl extends \RectorPrefix2020DecSat\Nette\Application\UI\Control
{
    public function createComponentAnother() : \Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source\AnotherControl
    {
        return new \Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\Source\AnotherControl();
    }
}
