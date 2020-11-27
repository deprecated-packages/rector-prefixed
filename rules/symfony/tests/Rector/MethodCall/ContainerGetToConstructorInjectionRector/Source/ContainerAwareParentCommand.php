<?php

declare (strict_types=1);
namespace Rector\Symfony\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScoperbd5d0c5f7638\Symfony\Component\Console\Command\Command;
use _PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentCommand extends \_PhpScoperbd5d0c5f7638\Symfony\Component\Console\Command\Command
{
    public function getContainer() : \_PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
