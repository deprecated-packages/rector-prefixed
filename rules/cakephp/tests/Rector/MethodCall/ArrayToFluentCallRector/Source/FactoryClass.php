<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source;

class FactoryClass
{
    public function buildClass($arg1, array $options = []) : \_PhpScoperb75b35f52b74\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\ConfigurableClass
    {
        $configurableClass = new \_PhpScoperb75b35f52b74\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\ConfigurableClass();
        $configurableClass->setName($options['name']);
        return $configurableClass;
    }
}
