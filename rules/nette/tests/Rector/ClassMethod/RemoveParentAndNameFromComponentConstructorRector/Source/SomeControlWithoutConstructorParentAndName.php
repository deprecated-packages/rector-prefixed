<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Nette\Tests\Rector\ClassMethod\RemoveParentAndNameFromComponentConstructorRector\Source;

use _PhpScoper0a6b37af0871\Nette\Application\UI\Control;
final class SomeControlWithoutConstructorParentAndName extends \_PhpScoper0a6b37af0871\Nette\Application\UI\Control
{
    private $key;
    private $value;
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}
