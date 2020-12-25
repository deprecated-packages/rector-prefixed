<?php

declare (strict_types=1);
namespace Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScoper8b9c402c5f32\Symfony\Component\Console\Command\Command;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentCommand extends \_PhpScoper8b9c402c5f32\Symfony\Component\Console\Command\Command
{
    public function getContainer() : \_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
