<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Nette\Tests\Rector\ClassMethod\RemoveParentAndNameFromComponentConstructorRector\Source;

use _PhpScopere8e811afab72\Nette\Application\UI\Control;
final class SomeControlWithConstructorParentAndName extends \_PhpScopere8e811afab72\Nette\Application\UI\Control
{
    public function __construct($parent = null, $name = '')
    {
        $this->parent = $parent;
        $this->name = $name;
    }
}
