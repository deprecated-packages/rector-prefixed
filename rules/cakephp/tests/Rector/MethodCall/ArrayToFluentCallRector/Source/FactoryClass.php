<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source;

class FactoryClass
{
    public function buildClass($arg1, array $options = []) : \_PhpScoper0a6b37af0871\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\ConfigurableClass
    {
        $configurableClass = new \_PhpScoper0a6b37af0871\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\ConfigurableClass();
        $configurableClass->setName($options['name']);
        return $configurableClass;
    }
}
