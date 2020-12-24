<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source;

class FactoryClass
{
    public function buildClass($arg1, array $options = []) : \_PhpScopere8e811afab72\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\ConfigurableClass
    {
        $configurableClass = new \_PhpScopere8e811afab72\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\ConfigurableClass();
        $configurableClass->setName($options['name']);
        return $configurableClass;
    }
}
