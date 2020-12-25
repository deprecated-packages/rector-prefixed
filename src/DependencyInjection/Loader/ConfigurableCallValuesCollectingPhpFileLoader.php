<?php

declare (strict_types=1);
namespace Rector\Core\DependencyInjection\Loader;

use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\DependencyInjection\Collector\ConfigureCallValuesCollector;
use _PhpScoper17db12703726\Symfony\Component\Config\FileLocatorInterface;
use _PhpScoper17db12703726\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper17db12703726\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class ConfigurableCallValuesCollectingPhpFileLoader extends \_PhpScoper17db12703726\Symfony\Component\DependencyInjection\Loader\PhpFileLoader
{
    /**
     * @var ConfigureCallValuesCollector
     */
    private $configureCallValuesCollector;
    public function __construct(\_PhpScoper17db12703726\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, \_PhpScoper17db12703726\Symfony\Component\Config\FileLocatorInterface $fileLocator, \Rector\Core\DependencyInjection\Collector\ConfigureCallValuesCollector $configureCallValuesCollector)
    {
        $this->configureCallValuesCollector = $configureCallValuesCollector;
        parent::__construct($containerBuilder, $fileLocator);
    }
    public function import($resource, $type = null, $ignoreErrors = \false, $sourceResource = null, $exclude = null) : void
    {
        // this call collects root values
        $this->collectConfigureCallsFromJustImportedConfigurableRectorDefinitions();
        parent::import($resource, $type, $ignoreErrors, $sourceResource, $exclude);
        $this->collectConfigureCallsFromJustImportedConfigurableRectorDefinitions();
    }
    private function collectConfigureCallsFromJustImportedConfigurableRectorDefinitions() : void
    {
        foreach ($this->container->getDefinitions() as $class => $definition) {
            /** @var string $class */
            if (!\is_a($class, \Rector\Core\Contract\Rector\ConfigurableRectorInterface::class, \true)) {
                continue;
            }
            $this->configureCallValuesCollector->collectFromServiceAndClassName($class, $definition);
        }
    }
}
