<?php

namespace Rector\Nette\Tests\Rector\Class_\MoveInjectToExistingConstructorRector\Fixture;

use Rector\Nette\Tests\Rector\Class_\MoveInjectToExistingConstructorRector\Source\ClassWithParentConstructor;

final class SkipIfParentConstructor extends ClassWithParentConstructor
{
    /**
     * @var SomeDependency
     * @inject
     */
    public $someDependency;
}
