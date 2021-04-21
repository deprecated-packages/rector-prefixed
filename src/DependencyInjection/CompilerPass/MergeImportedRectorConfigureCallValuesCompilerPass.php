<?php

declare (strict_types=1);
namespace Rector\Core\DependencyInjection\CompilerPass;

use Rector\Core\DependencyInjection\Collector\ConfigureCallValuesCollector;
use RectorPrefix20210421\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use RectorPrefix20210421\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210421\Symfony\Component\DependencyInjection\Definition;
final class MergeImportedRectorConfigureCallValuesCompilerPass implements \RectorPrefix20210421\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * @var string
     */
    const CONFIGURE_METHOD_NAME = 'configure';
    /**
     * @var ConfigureCallValuesCollector
     */
    private $configureCallValuesCollector;
    public function __construct(\Rector\Core\DependencyInjection\Collector\ConfigureCallValuesCollector $configureCallValuesCollector)
    {
        $this->configureCallValuesCollector = $configureCallValuesCollector;
    }
    /**
     * @return void
     */
    public function process(\RectorPrefix20210421\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder)
    {
        foreach ($containerBuilder->getDefinitions() as $id => $definition) {
            $this->completeCollectedArguments($id, $definition);
        }
    }
    /**
     * @return void
     */
    private function completeCollectedArguments(string $serviceClass, \RectorPrefix20210421\Symfony\Component\DependencyInjection\Definition $definition)
    {
        $configureCallValues = $this->configureCallValuesCollector->getConfigureCallValues($serviceClass);
        if ($configureCallValues === []) {
            return;
        }
        $definition->removeMethodCall(self::CONFIGURE_METHOD_NAME);
        $definition->addMethodCall(self::CONFIGURE_METHOD_NAME, [$configureCallValues]);
    }
}
