<?php

declare (strict_types=1);
namespace Rector\Tests\Symfony4\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use RectorPrefix20210318\Symfony\Component\Console\Command\Command;
use RectorPrefix20210318\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentCommand extends \RectorPrefix20210318\Symfony\Component\Console\Command\Command
{
    public function getContainer() : \RectorPrefix20210318\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
