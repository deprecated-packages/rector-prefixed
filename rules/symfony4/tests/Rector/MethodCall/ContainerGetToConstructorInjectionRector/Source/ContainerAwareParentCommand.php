<?php

declare (strict_types=1);
namespace Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScoper5edc98a7cce2\Symfony\Component\Console\Command\Command;
use _PhpScoper5edc98a7cce2\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentCommand extends \_PhpScoper5edc98a7cce2\Symfony\Component\Console\Command\Command
{
    public function getContainer() : \_PhpScoper5edc98a7cce2\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
