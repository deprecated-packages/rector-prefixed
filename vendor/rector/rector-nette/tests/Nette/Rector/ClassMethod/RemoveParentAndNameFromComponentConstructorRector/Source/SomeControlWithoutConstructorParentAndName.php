<?php

declare (strict_types=1);
namespace Rector\Tests\Nette\Rector\ClassMethod\RemoveParentAndNameFromComponentConstructorRector\Source;

use RectorPrefix20210319\Nette\Application\UI\Control;
final class SomeControlWithoutConstructorParentAndName extends \RectorPrefix20210319\Nette\Application\UI\Control
{
    private $key;
    private $value;
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}
