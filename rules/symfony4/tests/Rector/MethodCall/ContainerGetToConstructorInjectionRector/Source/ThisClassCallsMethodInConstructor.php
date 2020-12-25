<?php

declare (strict_types=1);
namespace Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class ThisClassCallsMethodInConstructor
{
    public function __construct()
    {
        $this->prepareEverything();
    }
    public function getContainer() : \_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
    private function prepareEverything()
    {
    }
}
