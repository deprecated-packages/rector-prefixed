<?php

declare (strict_types=1);
namespace Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use RectorPrefix20210215\Symfony\Component\Console\Command\Command;
use RectorPrefix20210215\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentCommand extends \RectorPrefix20210215\Symfony\Component\Console\Command\Command
{
    public function getContainer() : \RectorPrefix20210215\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
