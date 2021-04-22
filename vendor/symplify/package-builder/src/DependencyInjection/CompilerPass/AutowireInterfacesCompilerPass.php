<?php

declare (strict_types=1);
namespace RectorPrefix20210422\Symplify\PackageBuilder\DependencyInjection\CompilerPass;

use RectorPrefix20210422\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use RectorPrefix20210422\Symfony\Component\DependencyInjection\ContainerBuilder;
final class AutowireInterfacesCompilerPass implements \RectorPrefix20210422\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * @var string[]
     */
    private $typesToAutowire = [];
    /**
     * @param string[] $typesToAutowire
     */
    public function __construct(array $typesToAutowire)
    {
        $this->typesToAutowire = $typesToAutowire;
    }
    /**
     * @return void
     */
    public function process(\RectorPrefix20210422\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder)
    {
        $containerBuilderDefinitions = $containerBuilder->getDefinitions();
        foreach ($containerBuilderDefinitions as $definition) {
            foreach ($this->typesToAutowire as $typeToAutowire) {
                if (!\is_a((string) $definition->getClass(), $typeToAutowire, \true)) {
                    continue;
                }
                $definition->setAutowired(\true);
                continue 2;
            }
        }
    }
}
