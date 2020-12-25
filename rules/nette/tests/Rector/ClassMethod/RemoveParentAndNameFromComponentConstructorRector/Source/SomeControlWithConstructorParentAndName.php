<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\ClassMethod\RemoveParentAndNameFromComponentConstructorRector\Source;

use _PhpScoperbf340cb0be9d\Nette\Application\UI\Control;
final class SomeControlWithConstructorParentAndName extends \_PhpScoperbf340cb0be9d\Nette\Application\UI\Control
{
    public function __construct($parent = null, $name = '')
    {
        $this->parent = $parent;
        $this->name = $name;
    }
}
