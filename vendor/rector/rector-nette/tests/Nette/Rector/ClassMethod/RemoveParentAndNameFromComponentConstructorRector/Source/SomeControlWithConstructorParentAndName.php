<?php

declare (strict_types=1);
namespace Rector\Tests\Nette\Rector\ClassMethod\RemoveParentAndNameFromComponentConstructorRector\Source;

use RectorPrefix20210320\Nette\Application\UI\Control;
final class SomeControlWithConstructorParentAndName extends \RectorPrefix20210320\Nette\Application\UI\Control
{
    public function __construct($parent = null, $name = '')
    {
        $this->parent = $parent;
        $this->name = $name;
    }
}
