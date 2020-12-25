<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\ClassMethod\RemoveParentAndNameFromComponentConstructorRector\Source;

use _PhpScoperbf340cb0be9d\Nette\Application\UI\Control;
final class SomeControlWithoutConstructorParentAndName extends \_PhpScoperbf340cb0be9d\Nette\Application\UI\Control
{
    private $key;
    private $value;
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}
