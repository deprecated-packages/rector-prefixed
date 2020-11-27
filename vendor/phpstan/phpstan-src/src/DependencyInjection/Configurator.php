<?php

declare (strict_types=1);
namespace PHPStan\DependencyInjection;

use _PhpScoperbd5d0c5f7638\Nette\DI\Config\Loader;
use _PhpScoperbd5d0c5f7638\Nette\DI\ContainerLoader;
class Configurator extends \_PhpScoperbd5d0c5f7638\Nette\Configurator
{
    /**
     * @var \PHPStan\DependencyInjection\LoaderFactory
     */
    private $loaderFactory;
    public function __construct(\PHPStan\DependencyInjection\LoaderFactory $loaderFactory)
    {
        $this->loaderFactory = $loaderFactory;
        parent::__construct();
    }
    protected function createLoader() : \_PhpScoperbd5d0c5f7638\Nette\DI\Config\Loader
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
        $loader = new \_PhpScoperbd5d0c5f7638\Nette\DI\ContainerLoader($this->getCacheDirectory() . '/nette.configurator', $this->parameters['debugMode']);
        return $loader->load([$this, 'generateContainer'], [$this->parameters, \array_keys($this->dynamicParameters), $this->configs, \PHP_VERSION_ID - \PHP_RELEASE_VERSION, \PHPStan\DependencyInjection\NeonAdapter::CACHE_KEY]);
    }
}
