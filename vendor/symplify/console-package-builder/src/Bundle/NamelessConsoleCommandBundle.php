<?php

declare (strict_types=1);
namespace RectorPrefix20210422\Symplify\ConsolePackageBuilder\Bundle;

use RectorPrefix20210422\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210422\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210422\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass;
final class NamelessConsoleCommandBundle extends \RectorPrefix20210422\Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * @return void
     */
    public function build(\RectorPrefix20210422\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder)
    {
        $containerBuilder->addCompilerPass(new \RectorPrefix20210422\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass());
    }
}
