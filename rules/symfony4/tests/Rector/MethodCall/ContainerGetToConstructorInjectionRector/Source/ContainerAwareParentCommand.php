<?php

declare (strict_types=1);
namespace Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScoper567b66d83109\Symfony\Component\Console\Command\Command;
use _PhpScoper567b66d83109\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentCommand extends \_PhpScoper567b66d83109\Symfony\Component\Console\Command\Command
{
    public function getContainer() : \_PhpScoper567b66d83109\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
