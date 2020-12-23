<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Command\Command;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentCommand extends \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Command\Command
{
    public function getContainer() : \_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
