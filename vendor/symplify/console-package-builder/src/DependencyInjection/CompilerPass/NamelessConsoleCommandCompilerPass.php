<?php

declare (strict_types=1);
namespace RectorPrefix20210408\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass;

use RectorPrefix20210408\Symfony\Component\Console\Command\Command;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210408\Symplify\PackageBuilder\Console\Command\CommandNaming;
/**
 * @see \Symplify\ConsolePackageBuilder\Tests\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPassTest
 */
final class NamelessConsoleCommandCompilerPass implements \RectorPrefix20210408\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    public function process(\RectorPrefix20210408\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        foreach ($containerBuilder->getDefinitions() as $definition) {
            $definitionClass = $definition->getClass();
            if ($definitionClass === null) {
                continue;
            }
            if (!\is_a($definitionClass, \RectorPrefix20210408\Symfony\Component\Console\Command\Command::class, \true)) {
                continue;
            }
            $commandName = \RectorPrefix20210408\Symplify\PackageBuilder\Console\Command\CommandNaming::classToName($definitionClass);
            $definition->addMethodCall('setName', [$commandName]);
        }
    }
}
