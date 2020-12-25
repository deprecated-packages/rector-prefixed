<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\ClassMethod\RemoveParentAndNameFromComponentConstructorRector\Source;

use _PhpScoper5b8c9e9ebd21\Nette\Application\UI\Control;
final class SomeControlWithConstructorParentAndName extends \_PhpScoper5b8c9e9ebd21\Nette\Application\UI\Control
{
    public function __construct($parent = null, $name = '')
    {
        $this->parent = $parent;
        $this->name = $name;
    }
}
