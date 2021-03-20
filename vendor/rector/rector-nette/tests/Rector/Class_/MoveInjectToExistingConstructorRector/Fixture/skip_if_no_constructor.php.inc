<?php

namespace Rector\Nette\Tests\Rector\Class_\MoveInjectToExistingConstructorRector\Fixture;

final class SkipIfNoConstructor
{
    /**
     * @var SomeDependency
     * @inject
     */
    public $someDependency;
}
