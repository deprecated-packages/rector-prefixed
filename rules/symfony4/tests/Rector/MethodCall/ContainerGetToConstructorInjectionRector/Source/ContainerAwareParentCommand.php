<?php

declare (strict_types=1);
namespace Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use RectorPrefix2020DecSat\Symfony\Component\Console\Command\Command;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentCommand extends \RectorPrefix2020DecSat\Symfony\Component\Console\Command\Command
{
    public function getContainer() : \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
