<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Command\Command;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentCommand extends \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Command\Command
{
    public function getContainer() : \_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
