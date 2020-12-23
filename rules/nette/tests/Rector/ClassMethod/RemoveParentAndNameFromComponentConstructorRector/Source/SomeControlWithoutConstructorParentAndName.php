<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Nette\Tests\Rector\ClassMethod\RemoveParentAndNameFromComponentConstructorRector\Source;

use _PhpScoper0a2ac50786fa\Nette\Application\UI\Control;
final class SomeControlWithoutConstructorParentAndName extends \_PhpScoper0a2ac50786fa\Nette\Application\UI\Control
{
    private $key;
    private $value;
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}
