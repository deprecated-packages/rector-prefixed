<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader;

use RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
/**
 * PhpFileLoader loads service definitions from a PHP file.
 *
 * The PHP file is required and the $container variable can be
 * used within the file to change the container.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class PhpFileLoader extends \RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\FileLoader
{
    protected $autoRegisterAliasesForSinglyImplementedInterfaces = \false;
    /**
     * {@inheritdoc}
     */
    public function load($resource, $type = null)
    {
        // the container and loader variables are exposed to the included file below
        $container = $this->container;
        $loader = $this;
        $path = $this->locator->locate($resource);
        $this->setCurrentDir(\dirname($path));
        $this->container->fileExists($path);
        // the closure forbids access to the private scope in the included file
        $load = \Closure::bind(function ($path) use($container, $loader, $resource, $type) {
            return include $path;
        }, $this, \RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\ProtectedPhpFileLoader::class);
        try {
            $callback = $load($path);
            if (\is_object($callback) && \is_callable($callback)) {
                $callback(new \RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator($this->container, $this, $this->instanceof, $path, $resource), $this->container, $this);
            }
        } finally {
            $this->instanceof = [];
            $this->registerAliasesForSinglyImplementedInterfaces();
        }
    }
    /**
     * {@inheritdoc}
     */
    public function supports($resource, string $type = null)
    {
        if (!\is_string($resource)) {
            return \false;
        }
        if (null === $type && 'php' === \pathinfo($resource, \PATHINFO_EXTENSION)) {
            return \true;
        }
        return 'php' === $type;
    }
}
/**
 * @internal
 */
final class ProtectedPhpFileLoader extends \RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\PhpFileLoader
{
}
