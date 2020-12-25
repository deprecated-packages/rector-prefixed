<?php

declare (strict_types=1);
namespace Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScoper50d83356d739\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentClass
{
    public function getContainer() : \_PhpScoper50d83356d739\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
