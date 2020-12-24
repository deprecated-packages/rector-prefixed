<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class ThisClassCallsMethodInConstructor
{
    public function __construct()
    {
        $this->prepareEverything();
    }
    public function getContainer() : \_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
    private function prepareEverything()
    {
    }
}
