<?php

declare (strict_types=1);
namespace Rector\Symfony\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScopera143bcca66cb\Symfony\Component\Console\Command\Command;
use _PhpScopera143bcca66cb\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentCommand extends \_PhpScopera143bcca66cb\Symfony\Component\Console\Command\Command
{
    public function getContainer() : \_PhpScopera143bcca66cb\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
