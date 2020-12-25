<?php

declare (strict_types=1);
namespace Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScoper5edc98a7cce2\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class ThisClassCallsMethodInConstructor
{
    public function __construct()
    {
        $this->prepareEverything();
    }
    public function getContainer() : \_PhpScoper5edc98a7cce2\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
    private function prepareEverything()
    {
    }
}
