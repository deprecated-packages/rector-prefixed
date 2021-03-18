<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210318\Symfony\Component\DependencyInjection\Loader\Configurator;

use RectorPrefix20210318\Symfony\Component\DependencyInjection\Definition;
use RectorPrefix20210318\Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
abstract class AbstractServiceConfigurator extends \RectorPrefix20210318\Symfony\Component\DependencyInjection\Loader\Configurator\AbstractConfigurator
{
    protected $parent;
    protected $id;
    private $defaultTags = [];
    public function __construct(\RectorPrefix20210318\Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator $parent, \RectorPrefix20210318\Symfony\Component\DependencyInjection\Definition $definition, string $id = null, array $defaultTags = [])
    {
        $this->parent = $parent;
        $this->definition = $definition;
        $this->id = $id;
        $this->defaultTags = $defaultTags;
    }
    public function __destruct()
    {
        // default tags should be added last
        foreach ($this->defaultTags as $name => $attributes) {
            foreach ($attributes as $attributes) {
                $this->definition->addTag($name, $attributes);
            }
        }
        $this->defaultTags = [];
    }
    /**
     * Registers a service.
     * @param string|null $id
     * @param string $class
     */
    public final function set($id, $class = null) : \RectorPrefix20210318\Symfony\Component\DependencyInjection\Loader\Configurator\ServiceConfigurator
    {
        $this->__destruct();
        return $this->parent->set($id, $class);
    }
    /**
     * Creates an alias.
     * @param string $id
     * @param string $referencedId
     */
    public final function alias($id, $referencedId) : \RectorPrefix20210318\Symfony\Component\DependencyInjection\Loader\Configurator\AliasConfigurator
    {
        $this->__destruct();
        return $this->parent->alias($id, $referencedId);
    }
    /**
     * Registers a PSR-4 namespace using a glob pattern.
     * @param string $namespace
     * @param string $resource
     */
    public final function load($namespace, $resource) : \RectorPrefix20210318\Symfony\Component\DependencyInjection\Loader\Configurator\PrototypeConfigurator
    {
        $this->__destruct();
        return $this->parent->load($namespace, $resource);
    }
    /**
     * Gets an already defined service definition.
     *
     * @throws ServiceNotFoundException if the service definition does not exist
     * @param string $id
     */
    public final function get($id) : \RectorPrefix20210318\Symfony\Component\DependencyInjection\Loader\Configurator\ServiceConfigurator
    {
        $this->__destruct();
        return $this->parent->get($id);
    }
    /**
     * Registers a stack of decorator services.
     *
     * @param InlineServiceConfigurator[]|ReferenceConfigurator[] $services
     * @param string $id
     */
    public final function stack($id, $services) : \RectorPrefix20210318\Symfony\Component\DependencyInjection\Loader\Configurator\AliasConfigurator
    {
        $this->__destruct();
        return $this->parent->stack($id, $services);
    }
    /**
     * Registers a service.
     */
    public final function __invoke(string $id, string $class = null) : \RectorPrefix20210318\Symfony\Component\DependencyInjection\Loader\Configurator\ServiceConfigurator
    {
        $this->__destruct();
        return $this->parent->set($id, $class);
    }
}
