<?php

declare (strict_types=1);
namespace Rector\Core\DependencyInjection\CompilerPass;

use Rector\Core\Contract\Rector\RectorInterface;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\ContainerBuilder;
/**
 * Needed for @see \Rector\Core\Configuration\RectorClassesProvider
 */
final class MakeRectorsPublicCompilerPass implements \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    public function process(\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        foreach ($containerBuilder->getDefinitions() as $definition) {
            if ($definition->getClass() === null) {
                continue;
            }
            if (!\is_a($definition->getClass(), \Rector\Core\Contract\Rector\RectorInterface::class, \true)) {
                continue;
            }
            $definition->setPublic(\true);
        }
    }
}
