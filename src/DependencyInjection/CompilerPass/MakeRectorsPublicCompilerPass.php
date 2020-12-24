<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\DependencyInjection\CompilerPass;

use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\RectorInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\ContainerBuilder;
/**
 * Needed for @see \Rector\Core\Configuration\RectorClassesProvider
 */
final class MakeRectorsPublicCompilerPass implements \_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    public function process(\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        foreach ($containerBuilder->getDefinitions() as $definition) {
            if ($definition->getClass() === null) {
                continue;
            }
            if (!\is_a($definition->getClass(), \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\RectorInterface::class, \true)) {
                continue;
            }
            $definition->setPublic(\true);
        }
    }
}
