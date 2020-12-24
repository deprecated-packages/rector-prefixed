<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\DependencyInjection\CompilerPass;

use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\RectorInterface;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerBuilder;
/**
 * Needed for @see \Rector\Core\Configuration\RectorClassesProvider
 */
final class MakeRectorsPublicCompilerPass implements \_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    public function process(\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        foreach ($containerBuilder->getDefinitions() as $definition) {
            if ($definition->getClass() === null) {
                continue;
            }
            if (!\is_a($definition->getClass(), \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\RectorInterface::class, \true)) {
                continue;
            }
            $definition->setPublic(\true);
        }
    }
}
