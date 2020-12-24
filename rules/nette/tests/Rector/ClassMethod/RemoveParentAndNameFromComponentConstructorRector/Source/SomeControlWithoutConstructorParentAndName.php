<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Nette\Tests\Rector\ClassMethod\RemoveParentAndNameFromComponentConstructorRector\Source;

use _PhpScoperb75b35f52b74\Nette\Application\UI\Control;
final class SomeControlWithoutConstructorParentAndName extends \_PhpScoperb75b35f52b74\Nette\Application\UI\Control
{
    private $key;
    private $value;
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}
