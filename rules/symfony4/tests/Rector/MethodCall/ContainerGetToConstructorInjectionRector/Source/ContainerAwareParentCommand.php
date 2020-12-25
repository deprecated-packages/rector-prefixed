<?php

declare (strict_types=1);
namespace Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScoper267b3276efc2\Symfony\Component\Console\Command\Command;
use _PhpScoper267b3276efc2\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentCommand extends \_PhpScoper267b3276efc2\Symfony\Component\Console\Command\Command
{
    public function getContainer() : \_PhpScoper267b3276efc2\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
