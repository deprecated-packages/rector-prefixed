<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\DependencyInjection\CompilerPass;

use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\RectorInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerBuilder;
/**
 * Needed for @see \Rector\Core\Configuration\RectorClassesProvider
 */
final class MakeRectorsPublicCompilerPass implements \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    public function process(\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        foreach ($containerBuilder->getDefinitions() as $definition) {
            if ($definition->getClass() === null) {
                continue;
            }
            if (!\is_a($definition->getClass(), \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\RectorInterface::class, \true)) {
                continue;
            }
            $definition->setPublic(\true);
        }
    }
}
