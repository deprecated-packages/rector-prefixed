<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\DependencyInjection;

use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\DI\Config\Loader;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\DI\ContainerLoader;
class Configurator extends \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\Configurator
{
    /** @var LoaderFactory */
    private $loaderFactory;
    public function __construct(\RectorPrefix20201227\PHPStan\DependencyInjection\LoaderFactory $loaderFactory)
    {
        $this->loaderFactory = $loaderFactory;
        parent::__construct();
    }
    protected function createLoader() : \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\DI\Config\Loader
    {
        return $this->loaderFactory->createLoader();
    }
    /**
     * @return mixed[]
     */
    protected function getDefaultParameters() : array
    {
        return [];
    }
    public function loadContainer() : string
    {
        $loader = new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\DI\ContainerLoader($this->getCacheDirectory() . '/nette.configurator', $this->parameters['debugMode']);
        return $loader->load([$this, 'generateContainer'], [$this->parameters, \array_keys($this->dynamicParameters), $this->configs, \PHP_VERSION_ID - \PHP_RELEASE_VERSION, \RectorPrefix20201227\PHPStan\DependencyInjection\NeonAdapter::CACHE_KEY]);
    }
}
