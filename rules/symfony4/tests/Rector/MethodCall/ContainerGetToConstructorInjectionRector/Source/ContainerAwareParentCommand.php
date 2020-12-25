<?php

declare (strict_types=1);
namespace Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScoperf18a0c41e2d2\Symfony\Component\Console\Command\Command;
use _PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentCommand extends \_PhpScoperf18a0c41e2d2\Symfony\Component\Console\Command\Command
{
    public function getContainer() : \_PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
