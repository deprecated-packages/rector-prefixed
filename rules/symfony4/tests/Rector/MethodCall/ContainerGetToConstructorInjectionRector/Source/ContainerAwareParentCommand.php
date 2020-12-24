<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScoper0a6b37af0871\Symfony\Component\Console\Command\Command;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentCommand extends \_PhpScoper0a6b37af0871\Symfony\Component\Console\Command\Command
{
    public function getContainer() : \_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
