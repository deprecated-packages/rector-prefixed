<?php

declare (strict_types=1);
namespace Rector\Core\DependencyInjection\Loader;

use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\DependencyInjection\Collector\ConfigureCallValuesCollector;
use RectorPrefix20210408\Symfony\Component\Config\FileLocatorInterface;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class ConfigurableCallValuesCollectingPhpFileLoader extends \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\PhpFileLoader
{
    /**
     * @var ConfigureCallValuesCollector
     */
    private $configureCallValuesCollector;
    public function __construct(\RectorPrefix20210408\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, \RectorPrefix20210408\Symfony\Component\Config\FileLocatorInterface $fileLocator, \Rector\Core\DependencyInjection\Collector\ConfigureCallValuesCollector $configureCallValuesCollector)
    {
        $this->configureCallValuesCollector = $configureCallValuesCollector;
        parent::__construct($containerBuilder, $fileLocator);
    }
    /**
     * @param mixed $resource
     * @param null|string $type
     */
    public function load($resource, $type = null) : void
    {
        // this call collects root values
        $this->collectConfigureCallsFromJustImportedConfigurableRectorDefinitions();
        parent::load($resource, $type);
        $this->collectConfigureCallsFromJustImportedConfigurableRectorDefinitions();
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
