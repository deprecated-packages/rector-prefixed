<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source;

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
