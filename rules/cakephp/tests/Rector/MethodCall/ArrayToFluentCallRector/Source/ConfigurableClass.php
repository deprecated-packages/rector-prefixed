<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source;

class ConfigurableClass
{
    public function setName(string $name) : self
    {
        return $this;
    }
    public function setSize(int $size) : self
    {
        return $this;
    }
    public function doSomething() : void
    {
    }
}
