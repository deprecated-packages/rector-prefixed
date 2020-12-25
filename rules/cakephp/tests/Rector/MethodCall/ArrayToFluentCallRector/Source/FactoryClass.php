<?php

declare (strict_types=1);
namespace Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source;

class FactoryClass
{
    public function buildClass($arg1, array $options = []) : \Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\ConfigurableClass
    {
        $configurableClass = new \Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\ConfigurableClass();
        $configurableClass->setName($options['name']);
        return $configurableClass;
    }
}
