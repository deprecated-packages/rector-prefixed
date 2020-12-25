<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\ClassMethod\RemoveParentAndNameFromComponentConstructorRector\Source;

use _PhpScoperf18a0c41e2d2\Nette\Application\UI\Control;
final class SomeControlWithConstructorParentAndName extends \_PhpScoperf18a0c41e2d2\Nette\Application\UI\Control
{
    public function __construct($parent = null, $name = '')
    {
        $this->parent = $parent;
        $this->name = $name;
    }
}
