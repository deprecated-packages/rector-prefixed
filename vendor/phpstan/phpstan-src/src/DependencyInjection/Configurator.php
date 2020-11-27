<?php

declare (strict_types=1);
namespace PHPStan\DependencyInjection;

use _PhpScoper26e51eeacccf\Nette\DI\Config\Loader;
use _PhpScoper26e51eeacccf\Nette\DI\ContainerLoader;
class Configurator extends \_PhpScoper26e51eeacccf\Nette\Configurator
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
    protected function createLoader() : \_PhpScoper26e51eeacccf\Nette\DI\Config\Loader
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
        $loader = new \_PhpScoper26e51eeacccf\Nette\DI\ContainerLoader($this->getCacheDirectory() . '/nette.configurator', $this->parameters['debugMode']);
        return $loader->load([$this, 'generateContainer'], [$this->parameters, \array_keys($this->dynamicParameters), $this->configs, \PHP_VERSION_ID - \PHP_RELEASE_VERSION, \PHPStan\DependencyInjection\NeonAdapter::CACHE_KEY]);
    }
}
