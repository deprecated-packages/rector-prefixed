<?php

declare (strict_types=1);
namespace Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentClass
{
    public function getContainer() : \_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
