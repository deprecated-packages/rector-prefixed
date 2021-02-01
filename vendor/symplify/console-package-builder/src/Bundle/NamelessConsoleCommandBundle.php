<?php

declare (strict_types=1);
namespace RectorPrefix20210201\Symplify\ConsolePackageBuilder\Bundle;

use RectorPrefix20210201\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210201\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210201\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass;
final class NamelessConsoleCommandBundle extends \RectorPrefix20210201\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\RectorPrefix20210201\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \RectorPrefix20210201\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass());
    }
}
