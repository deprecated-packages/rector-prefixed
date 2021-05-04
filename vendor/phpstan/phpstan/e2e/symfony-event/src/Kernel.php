<?php

namespace RectorPrefix20210504\App;

use RectorPrefix20210504\Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use RectorPrefix20210504\Symfony\Component\Config\Loader\LoaderInterface;
use RectorPrefix20210504\Symfony\Component\Config\Resource\FileResource;
use RectorPrefix20210504\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210504\Symfony\Component\HttpKernel\Kernel as BaseKernel;
use RectorPrefix20210504\Symfony\Component\Routing\RouteCollectionBuilder;
class Kernel extends \RectorPrefix20210504\Symfony\Component\HttpKernel\Kernel
{
    use MicroKernelTrait;
    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';
    public function registerBundles() : iterable
    {
        $contents = (require $this->getProjectDir() . '/config/bundles.php');
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? \false) {
                (yield new $class());
            }
        }
    }
    public function getProjectDir() : string
    {
        return \dirname(__DIR__);
    }
    protected function configureContainer(\RectorPrefix20210504\Symfony\Component\DependencyInjection\ContainerBuilder $container, \RectorPrefix20210504\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $container->addResource(new \RectorPrefix20210504\Symfony\Component\Config\Resource\FileResource($this->getProjectDir() . '/config/bundles.php'));
        $container->setParameter('container.dumper.inline_class_loader', \PHP_VERSION_ID < 70400 || $this->debug);
        $container->setParameter('container.dumper.inline_factories', \true);
        $confDir = $this->getProjectDir() . '/config';
        $loader->load($confDir . '/{packages}/*' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/{packages}/' . $this->environment . '/*' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/{services}' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/{services}_' . $this->environment . self::CONFIG_EXTS, 'glob');
    }
    protected function configureRoutes(\RectorPrefix20210504\Symfony\Component\Routing\RouteCollectionBuilder $routes) : void
    {
        $confDir = $this->getProjectDir() . '/config';
        $routes->import($confDir . '/{routes}/' . $this->environment . '/*' . self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir . '/{routes}/*' . self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir . '/{routes}' . self::CONFIG_EXTS, '/', 'glob');
    }
}
