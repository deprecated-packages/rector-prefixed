<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\DependencyInjection\Loader;

use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\DependencyInjection\Collector\ConfigureCallValuesCollector;
use _PhpScoper0a6b37af0871\Symfony\Component\Config\FileLocatorInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class ConfigurableCallValuesCollectingPhpFileLoader extends \_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\PhpFileLoader
{
    /**
     * @var ConfigureCallValuesCollector
     */
    private $configureCallValuesCollector;
    public function __construct(\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, \_PhpScoper0a6b37af0871\Symfony\Component\Config\FileLocatorInterface $fileLocator, \_PhpScoper0a6b37af0871\Rector\Core\DependencyInjection\Collector\ConfigureCallValuesCollector $configureCallValuesCollector)
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
            if (!\is_a($class, \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface::class, \true)) {
                continue;
            }
            $this->configureCallValuesCollector->collectFromServiceAndClassName($class, $definition);
        }
    }
}
