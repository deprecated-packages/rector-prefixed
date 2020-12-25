<?php

declare (strict_types=1);
namespace Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Command\Command;
use _PhpScoper5b8c9e9ebd21\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentCommand extends \_PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Command\Command
{
    public function getContainer() : \_PhpScoper5b8c9e9ebd21\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
