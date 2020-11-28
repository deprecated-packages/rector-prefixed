<?php

declare (strict_types=1);
namespace Rector\Symfony\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScoperabd03f0baf05\Symfony\Component\Console\Command\Command;
use _PhpScoperabd03f0baf05\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentCommand extends \_PhpScoperabd03f0baf05\Symfony\Component\Console\Command\Command
{
    public function getContainer() : \_PhpScoperabd03f0baf05\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
