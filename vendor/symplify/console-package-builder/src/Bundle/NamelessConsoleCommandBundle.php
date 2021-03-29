<?php

declare (strict_types=1);
namespace RectorPrefix20210329\Symplify\ConsolePackageBuilder\Bundle;

use RectorPrefix20210329\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210329\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210329\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass;
final class NamelessConsoleCommandBundle extends \RectorPrefix20210329\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\RectorPrefix20210329\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \RectorPrefix20210329\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass());
    }
}
