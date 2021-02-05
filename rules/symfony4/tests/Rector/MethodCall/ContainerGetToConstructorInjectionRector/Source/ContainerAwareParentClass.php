<?php

declare (strict_types=1);
namespace Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use RectorPrefix20210205\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentClass
{
    public function getContainer() : \RectorPrefix20210205\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
