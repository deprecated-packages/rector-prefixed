<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\DependencyInjection\CompilerPass;

use _PhpScoper2a4e7ab1ecbc\Rector\Core\DependencyInjection\Collector\ConfigureCallValuesCollector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Definition;
final class MergeImportedRectorConfigureCallValuesCompilerPass implements \_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * @var string
     */
    private const CONFIGURE_METHOD_NAME = 'configure';
    /**
     * @var ConfigureCallValuesCollector
     */
    private $configureCallValuesCollector;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\DependencyInjection\Collector\ConfigureCallValuesCollector $configureCallValuesCollector)
    {
        $this->configureCallValuesCollector = $configureCallValuesCollector;
    }
    public function process(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        foreach ($containerBuilder->getDefinitions() as $id => $definition) {
            $this->completeCollectedArguments($id, $definition);
        }
    }
    private function completeCollectedArguments(string $serviceClass, \_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Definition $definition) : void
    {
        $configureCallValues = $this->configureCallValuesCollector->getConfigureCallValues($serviceClass);
        if ($configureCallValues === []) {
            return;
        }
        $definition->removeMethodCall(self::CONFIGURE_METHOD_NAME);
        $definition->addMethodCall(self::CONFIGURE_METHOD_NAME, [$configureCallValues]);
    }
}
