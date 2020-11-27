<?php

declare (strict_types=1);
namespace Rector\Symfony\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScoper26e51eeacccf\Symfony\Component\Console\Command\Command;
use _PhpScoper26e51eeacccf\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentCommand extends \_PhpScoper26e51eeacccf\Symfony\Component\Console\Command\Command
{
    public function getContainer() : \_PhpScoper26e51eeacccf\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
