<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Nette\Tests\Rector\ClassMethod\RemoveParentAndNameFromComponentConstructorRector\Source;

use _PhpScoperb75b35f52b74\Nette\Application\UI\Control;
final class SomeControlWithConstructorParentAndName extends \_PhpScoperb75b35f52b74\Nette\Application\UI\Control
{
    public function __construct($parent = null, $name = '')
    {
        $this->parent = $parent;
        $this->name = $name;
    }
}
