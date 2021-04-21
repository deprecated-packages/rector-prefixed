<?php

declare (strict_types=1);
namespace RectorPrefix20210421\Symplify\ConsolePackageBuilder\Bundle;

use RectorPrefix20210421\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210421\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210421\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass;
final class NamelessConsoleCommandBundle extends \RectorPrefix20210421\Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * @return void
     */
    public function build(\RectorPrefix20210421\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder)
    {
        $containerBuilder->addCompilerPass(new \RectorPrefix20210421\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass());
    }
}
