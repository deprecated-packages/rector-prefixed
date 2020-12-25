<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\ClassMethod\RemoveParentAndNameFromComponentConstructorRector\Source;

use _PhpScoper8b9c402c5f32\Nette\Application\UI\Control;
final class SomeControlWithConstructorParentAndName extends \_PhpScoper8b9c402c5f32\Nette\Application\UI\Control
{
    public function __construct($parent = null, $name = '')
    {
        $this->parent = $parent;
        $this->name = $name;
    }
}
