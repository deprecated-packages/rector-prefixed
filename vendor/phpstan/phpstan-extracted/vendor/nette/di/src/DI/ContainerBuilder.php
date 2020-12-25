<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Nette\DI;

use _HumbugBox221ad6f1b81f\Nette;
use _HumbugBox221ad6f1b81f\Nette\DI\Definitions\Definition;
/**
 * Container builder.
 */
class ContainerBuilder
{
    use Nette\SmartObject;
    public const THIS_SERVICE = 'self', THIS_CONTAINER = 'container';
    /** @var array */
    public $parameters = [];
    /** @var Definition[] */
    private $definitions = [];
    /** @var array of alias => service */
    private $aliases = [];
    /** @var Autowiring */
    private $autowiring;
    /** @var bool */
    private $needsResolve = \true;
    /** @var bool */
    private $resolving = \false;
    /** @var array */
    private $dependencies = [];
    public function __construct()
    {
        $this->autowiring = new \_HumbugBox221ad6f1b81f\Nette\DI\Autowiring($this);
        $this->addImportedDefinition(self::THIS_CONTAINER)->setType(\_HumbugBox221ad6f1b81f\Nette\DI\Container::class);
    }
    /**
     * Adds new service definition.
     * @return Definitions\ServiceDefinition
     */
    public function addDefinition(?string $name, \_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Definition $definition = null) : \_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Definition
    {
        $this->needsResolve = \true;
        if ($name === null) {
            for ($i = 1; isset($this->definitions['0' . $i]) || isset($this->aliases['0' . $i]); $i++) {
            }
            $name = '0' . $i;
            // prevents converting to integer in array key
        } elseif (\is_int(\key([$name => 1])) || !\preg_match('#^\\w+(\\.\\w+)*$#D', $name)) {
            throw new \_HumbugBox221ad6f1b81f\Nette\InvalidArgumentException(\sprintf('Service name must be a alpha-numeric string and not a number, %s given.', \gettype($name)));
        } else {
            $name = $this->aliases[$name] ?? $name;
            if (isset($this->definitions[$name])) {
                throw new \_HumbugBox221ad6f1b81f\Nette\InvalidStateException("Service '{$name}' has already been added.");
            }
            $lname = \strtolower($name);
            foreach ($this->definitions as $nm => $foo) {
                if ($lname === \strtolower($nm)) {
                    throw new \_HumbugBox221ad6f1b81f\Nette\InvalidStateException("Service '{$name}' has the same name as '{$nm}' in a case-insensitive manner.");
                }
            }
        }
        $definition = $definition ?: new \_HumbugBox221ad6f1b81f\Nette\DI\Definitions\ServiceDefinition();
        $definition->setName($name);
        $definition->setNotifier(function () : void {
            $this->needsResolve = \true;
        });
        return $this->definitions[$name] = $definition;
    }
    public function addAccessorDefinition(?string $name) : \_HumbugBox221ad6f1b81f\Nette\DI\Definitions\AccessorDefinition
    {
        return $this->addDefinition($name, new \_HumbugBox221ad6f1b81f\Nette\DI\Definitions\AccessorDefinition());
    }
    public function addFactoryDefinition(?string $name) : \_HumbugBox221ad6f1b81f\Nette\DI\Definitions\FactoryDefinition
    {
        return $this->addDefinition($name, new \_HumbugBox221ad6f1b81f\Nette\DI\Definitions\FactoryDefinition());
    }
    public function addLocatorDefinition(?string $name) : \_HumbugBox221ad6f1b81f\Nette\DI\Definitions\LocatorDefinition
    {
        return $this->addDefinition($name, new \_HumbugBox221ad6f1b81f\Nette\DI\Definitions\LocatorDefinition());
    }
    public function addImportedDefinition(?string $name) : \_HumbugBox221ad6f1b81f\Nette\DI\Definitions\ImportedDefinition
    {
        return $this->addDefinition($name, new \_HumbugBox221ad6f1b81f\Nette\DI\Definitions\ImportedDefinition());
    }
    /**
     * Removes the specified service definition.
     */
    public function removeDefinition(string $name) : void
    {
        $this->needsResolve = \true;
        $name = $this->aliases[$name] ?? $name;
        unset($this->definitions[$name]);
    }
    /**
     * Gets the service definition.
     */
    public function getDefinition(string $name) : \_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Definition
    {
        $service = $this->aliases[$name] ?? $name;
        if (!isset($this->definitions[$service])) {
            throw new \_HumbugBox221ad6f1b81f\Nette\DI\MissingServiceException("Service '{$name}' not found.");
        }
        return $this->definitions[$service];
    }
    /**
     * Gets all service definitions.
     * @return Definition[]
     */
    public function getDefinitions() : array
    {
        return $this->definitions;
    }
    /**
     * Does the service definition or alias exist?
     */
    public function hasDefinition(string $name) : bool
    {
        $name = $this->aliases[$name] ?? $name;
        return isset($this->definitions[$name]);
    }
    public function addAlias(string $alias, string $service) : void
    {
        if (!$alias) {
            // builder is not ready for falsy names such as '0'
            throw new \_HumbugBox221ad6f1b81f\Nette\InvalidArgumentException(\sprintf('Alias name must be a non-empty string, %s given.', \gettype($alias)));
        } elseif (!$service) {
            // builder is not ready for falsy names such as '0'
            throw new \_HumbugBox221ad6f1b81f\Nette\InvalidArgumentException(\sprintf('Service name must be a non-empty string, %s given.', \gettype($service)));
        } elseif (isset($this->aliases[$alias])) {
            throw new \_HumbugBox221ad6f1b81f\Nette\InvalidStateException("Alias '{$alias}' has already been added.");
        } elseif (isset($this->definitions[$alias])) {
            throw new \_HumbugBox221ad6f1b81f\Nette\InvalidStateException("Service '{$alias}' has already been added.");
        }
        $this->aliases[$alias] = $service;
    }
    /**
     * Removes the specified alias.
     */
    public function removeAlias(string $alias) : void
    {
        unset($this->aliases[$alias]);
    }
    /**
     * Gets all service aliases.
     */
    public function getAliases() : array
    {
        return $this->aliases;
    }
    /**
     * @param  string[]  $types
     * @return static
     */
    public function addExcludedClasses(array $types)
    {
        $this->needsResolve = \true;
        $this->autowiring->addExcludedClasses($types);
        return $this;
    }
    /**
     * Resolves autowired service name by type.
     * @param  bool  $throw exception if service doesn't exist?
     * @throws MissingServiceException
     */
    public function getByType(string $type, bool $throw = \false) : ?string
    {
        $this->needResolved();
        return $this->autowiring->getByType($type, $throw);
    }
    /**
     * Gets autowired service definition of the specified type.
     * @throws MissingServiceException
     */
    public function getDefinitionByType(string $type) : \_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Definition
    {
        return $this->getDefinition($this->getByType($type, \true));
    }
    /**
     * Gets the autowired service names and definitions of the specified type.
     * @return Definition[]  service name is key
     * @internal
     */
    public function findAutowired(string $type) : array
    {
        $this->needResolved();
        return $this->autowiring->findByType($type);
    }
    /**
     * Gets the service names and definitions of the specified type.
     * @return Definition[]  service name is key
     */
    public function findByType(string $type) : array
    {
        $this->needResolved();
        $found = [];
        foreach ($this->definitions as $name => $def) {
            if (\is_a($def->getType(), $type, \true)) {
                $found[$name] = $def;
            }
        }
        return $found;
    }
    /**
     * Gets the service names and tag values.
     * @return array of [service name => tag attributes]
     */
    public function findByTag(string $tag) : array
    {
        $found = [];
        foreach ($this->definitions as $name => $def) {
            if (($tmp = $def->getTag($tag)) !== null) {
                $found[$name] = $tmp;
            }
        }
        return $found;
    }
    /********************* building ****************d*g**/
    /**
     * Checks services, resolves types and rebuilts autowiring classlist.
     */
    public function resolve() : void
    {
        if ($this->resolving) {
            return;
        }
        $this->resolving = \true;
        $resolver = new \_HumbugBox221ad6f1b81f\Nette\DI\Resolver($this);
        foreach ($this->definitions as $def) {
            $resolver->resolveDefinition($def);
        }
        $this->autowiring->rebuild();
        $this->resolving = $this->needsResolve = \false;
    }
    private function needResolved() : void
    {
        if ($this->resolving) {
            throw new \_HumbugBox221ad6f1b81f\Nette\DI\NotAllowedDuringResolvingException();
        } elseif ($this->needsResolve) {
            $this->resolve();
        }
    }
    public function complete() : void
    {
        $this->resolve();
        foreach ($this->definitions as $def) {
            $def->setNotifier(null);
        }
        $resolver = new \_HumbugBox221ad6f1b81f\Nette\DI\Resolver($this);
        foreach ($this->definitions as $def) {
            $resolver->completeDefinition($def);
        }
    }
    /**
     * Adds item to the list of dependencies.
     * @param  \ReflectionClass|\ReflectionFunctionAbstract|string  $dep
     * @return static
     * @internal
     */
    public function addDependency($dep)
    {
        $this->dependencies[] = $dep;
        return $this;
    }
    /**
     * Returns the list of dependencies.
     */
    public function getDependencies() : array
    {
        return $this->dependencies;
    }
    /** @internal */
    public function exportMeta() : array
    {
        $defs = $this->definitions;
        \ksort($defs);
        foreach ($defs as $name => $def) {
            if ($def instanceof \_HumbugBox221ad6f1b81f\Nette\DI\Definitions\ImportedDefinition) {
                $meta['types'][$name] = $def->getType();
            }
            foreach ($def->getTags() as $tag => $value) {
                $meta['tags'][$tag][$name] = $value;
            }
        }
        $meta['aliases'] = $this->aliases;
        \ksort($meta['aliases']);
        $all = [];
        foreach ($this->definitions as $name => $def) {
            if ($type = $def->getType()) {
                foreach (\class_parents($type) + \class_implements($type) + [$type] as $class) {
                    $all[$class][] = $name;
                }
            }
        }
        [$low, $high] = $this->autowiring->getClassList();
        foreach ($all as $class => $names) {
            $meta['wiring'][$class] = \array_filter([$high[$class] ?? [], $low[$class] ?? [], \array_diff($names, $low[$class] ?? [], $high[$class] ?? [])]);
        }
        return $meta;
    }
    public static function literal(string $code, array $args = null) : \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\PhpLiteral
    {
        return new \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\PhpLiteral($args === null ? $code : \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Helpers::formatArgs($code, $args));
    }
    /** @deprecated */
    public function formatPhp(string $statement, array $args) : string
    {
        \array_walk_recursive($args, function (&$val) : void {
            if ($val instanceof \_HumbugBox221ad6f1b81f\Nette\DI\Statement) {
                $val = (new \_HumbugBox221ad6f1b81f\Nette\DI\Resolver($this))->completeStatement($val);
            } elseif ($val instanceof \_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Definition) {
                $val = new \_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Reference($val->getName());
            }
        });
        return (new \_HumbugBox221ad6f1b81f\Nette\DI\PhpGenerator($this))->formatPhp($statement, $args);
    }
    /** @deprecated use resolve() */
    public function prepareClassList() : void
    {
        \trigger_error(__METHOD__ . '() is deprecated, use resolve()', \E_USER_DEPRECATED);
        $this->resolve();
    }
}
