<?php

declare (strict_types=1);
namespace Rector\Symfony\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScoper006a73f0e455\Symfony\Component\Console\Command\Command;
use _PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentCommand extends \_PhpScoper006a73f0e455\Symfony\Component\Console\Command\Command
{
    public function getContainer() : \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
