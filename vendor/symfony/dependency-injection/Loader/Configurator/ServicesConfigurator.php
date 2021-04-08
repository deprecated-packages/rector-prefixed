<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator;

use RectorPrefix20210408\Symfony\Component\DependencyInjection\Alias;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\ChildDefinition;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Definition;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ServicesConfigurator extends \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\AbstractConfigurator
{
    public const FACTORY = 'services';
    private $defaults;
    private $container;
    private $loader;
    private $instanceof;
    private $path;
    private $anonymousHash;
    private $anonymousCount;
    public function __construct(\RectorPrefix20210408\Symfony\Component\DependencyInjection\ContainerBuilder $container, \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\PhpFileLoader $loader, array &$instanceof, string $path = null, int &$anonymousCount = 0)
    {
        $this->defaults = new \RectorPrefix20210408\Symfony\Component\DependencyInjection\Definition();
        $this->container = $container;
        $this->loader = $loader;
        $this->instanceof =& $instanceof;
        $this->path = $path;
        $this->anonymousHash = \RectorPrefix20210408\Symfony\Component\DependencyInjection\ContainerBuilder::hash($path ?: \mt_rand());
        $this->anonymousCount =& $anonymousCount;
        $instanceof = [];
    }
    /**
     * Defines a set of defaults for following service definitions.
     */
    public final function defaults() : \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\DefaultsConfigurator
    {
        return new \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\DefaultsConfigurator($this, $this->defaults = new \RectorPrefix20210408\Symfony\Component\DependencyInjection\Definition(), $this->path);
    }
    /**
     * Defines an instanceof-conditional to be applied to following service definitions.
     */
    public final function instanceof(string $fqcn) : \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\InstanceofConfigurator
    {
        $this->instanceof[$fqcn] = $definition = new \RectorPrefix20210408\Symfony\Component\DependencyInjection\ChildDefinition('');
        return new \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\InstanceofConfigurator($this, $definition, $fqcn, $this->path);
    }
    /**
     * Registers a service.
     *
     * @param string|null $id    The service id, or null to create an anonymous service
     * @param string|null $class The class of the service, or null when $id is also the class name
     */
    public final function set(?string $id, string $class = null) : \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ServiceConfigurator
    {
        $defaults = $this->defaults;
        $definition = new \RectorPrefix20210408\Symfony\Component\DependencyInjection\Definition();
        if (null === $id) {
            if (!$class) {
                throw new \LogicException('Anonymous services must have a class name.');
            }
            $id = \sprintf('.%d_%s', ++$this->anonymousCount, \preg_replace('/^.*\\\\/', '', $class) . '~' . $this->anonymousHash);
        } elseif (!$defaults->isPublic() || !$defaults->isPrivate()) {
            $definition->setPublic($defaults->isPublic() && !$defaults->isPrivate());
        }
        $definition->setAutowired($defaults->isAutowired());
        $definition->setAutoconfigured($defaults->isAutoconfigured());
        // deep clone, to avoid multiple process of the same instance in the passes
        $definition->setBindings(\unserialize(\serialize($defaults->getBindings())));
        $definition->setChanges([]);
        $configurator = new \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ServiceConfigurator($this->container, $this->instanceof, \true, $this, $definition, $id, $defaults->getTags(), $this->path);
        return null !== $class ? $configurator->class($class) : $configurator;
    }
    /**
     * Creates an alias.
     */
    public final function alias(string $id, string $referencedId) : \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\AliasConfigurator
    {
        $ref = static::processValue($referencedId, \true);
        $alias = new \RectorPrefix20210408\Symfony\Component\DependencyInjection\Alias((string) $ref);
        if (!$this->defaults->isPublic() || !$this->defaults->isPrivate()) {
            $alias->setPublic($this->defaults->isPublic());
        }
        $this->container->setAlias($id, $alias);
        return new \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\AliasConfigurator($this, $alias);
    }
    /**
     * Registers a PSR-4 namespace using a glob pattern.
     */
    public final function load(string $namespace, string $resource) : \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\PrototypeConfigurator
    {
        return new \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\PrototypeConfigurator($this, $this->loader, $this->defaults, $namespace, $resource, \true);
    }
    /**
     * Gets an already defined service definition.
     *
     * @throws ServiceNotFoundException if the service definition does not exist
     */
    public final function get(string $id) : \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ServiceConfigurator
    {
        $definition = $this->container->getDefinition($id);
        return new \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ServiceConfigurator($this->container, $definition->getInstanceofConditionals(), \true, $this, $definition, $id, []);
    }
    /**
     * Registers a stack of decorator services.
     *
     * @param InlineServiceConfigurator[]|ReferenceConfigurator[] $services
     */
    public final function stack(string $id, array $services) : \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\AliasConfigurator
    {
        foreach ($services as $i => $service) {
            if ($service instanceof \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\InlineServiceConfigurator) {
                $definition = $service->definition->setInstanceofConditionals($this->instanceof);
                $changes = $definition->getChanges();
                $definition->setAutowired((isset($changes['autowired']) ? $definition : $this->defaults)->isAutowired());
                $definition->setAutoconfigured((isset($changes['autoconfigured']) ? $definition : $this->defaults)->isAutoconfigured());
                $definition->setBindings(\array_merge($this->defaults->getBindings(), $definition->getBindings()));
                $definition->setChanges($changes);
                $services[$i] = $definition;
            } elseif (!$service instanceof \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator) {
                throw new \RectorPrefix20210408\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('"%s()" expects a list of definitions as returned by "%s()" or "%s()", "%s" given at index "%s" for service "%s".', __METHOD__, \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\InlineServiceConfigurator::FACTORY, \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator::FACTORY, $service instanceof \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\AbstractConfigurator ? $service::FACTORY . '()' : \get_debug_type($service), $i, $id));
            }
        }
        $alias = $this->alias($id, '');
        $alias->definition = $this->set($id)->parent('')->args($services)->tag('container.stack')->definition;
        return $alias;
    }
    /**
     * Registers a service.
     */
    public final function __invoke(string $id, string $class = null) : \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ServiceConfigurator
    {
        return $this->set($id, $class);
    }
    public function __destruct()
    {
        $this->loader->registerAliasesForSinglyImplementedInterfaces();
    }
}
