<?php

declare (strict_types=1);
namespace Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScoperfce0de0de1ce\Symfony\Component\Console\Command\Command;
use _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentCommand extends \_PhpScoperfce0de0de1ce\Symfony\Component\Console\Command\Command
{
    public function getContainer() : \_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
