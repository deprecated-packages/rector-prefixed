<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Nette\Tests\Rector\ClassMethod\RemoveParentAndNameFromComponentConstructorRector\Source;

use _PhpScopere8e811afab72\Nette\Application\UI\Control;
final class SomeControlWithoutConstructorParentAndName extends \_PhpScopere8e811afab72\Nette\Application\UI\Control
{
    private $key;
    private $value;
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}
