<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\DependencyInjection;

use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Config\Loader;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\ContainerLoader;
class Configurator extends \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\Configurator
{
    /** @var LoaderFactory */
    private $loaderFactory;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\LoaderFactory $loaderFactory)
    {
        $this->loaderFactory = $loaderFactory;
        parent::__construct();
    }
    protected function createLoader() : \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Config\Loader
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
        $loader = new \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\ContainerLoader($this->getCacheDirectory() . '/nette.configurator', $this->parameters['debugMode']);
        return $loader->load([$this, 'generateContainer'], [$this->parameters, \array_keys($this->dynamicParameters), $this->configs, \PHP_VERSION_ID - \PHP_RELEASE_VERSION, \_PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\NeonAdapter::CACHE_KEY]);
    }
}
