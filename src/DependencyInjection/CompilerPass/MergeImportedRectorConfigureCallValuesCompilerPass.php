<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\DependencyInjection\CompilerPass;

use _PhpScoper0a6b37af0871\Rector\Core\DependencyInjection\Collector\ConfigureCallValuesCollector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Definition;
final class MergeImportedRectorConfigureCallValuesCompilerPass implements \_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * @var string
     */
    private const CONFIGURE_METHOD_NAME = 'configure';
    /**
     * @var ConfigureCallValuesCollector
     */
    private $configureCallValuesCollector;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\DependencyInjection\Collector\ConfigureCallValuesCollector $configureCallValuesCollector)
    {
        $this->configureCallValuesCollector = $configureCallValuesCollector;
    }
    public function process(\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        foreach ($containerBuilder->getDefinitions() as $id => $definition) {
            $this->completeCollectedArguments($id, $definition);
        }
    }
    private function completeCollectedArguments(string $serviceClass, \_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Definition $definition) : void
    {
        $configureCallValues = $this->configureCallValuesCollector->getConfigureCallValues($serviceClass);
        if ($configureCallValues === []) {
            return;
        }
        $definition->removeMethodCall(self::CONFIGURE_METHOD_NAME);
        $definition->addMethodCall(self::CONFIGURE_METHOD_NAME, [$configureCallValues]);
    }
}
