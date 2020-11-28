<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Nette\DI\Extensions;

use _PhpScoperabd03f0baf05\Nette;
use _PhpScoperabd03f0baf05\Nette\DI;
use _PhpScoperabd03f0baf05\Nette\DI\Definitions;
use _PhpScoperabd03f0baf05\Nette\Utils\Reflection;
/**
 * Calls inject methods and fills @inject properties.
 */
final class InjectExtension extends \_PhpScoperabd03f0baf05\Nette\DI\CompilerExtension
{
    public const TAG_INJECT = 'nette.inject';
    public function getConfigSchema() : \_PhpScoperabd03f0baf05\Nette\Schema\Schema
    {
        return \_PhpScoperabd03f0baf05\Nette\Schema\Expect::structure([]);
    }
    public function beforeCompile()
    {
        foreach ($this->getContainerBuilder()->getDefinitions() as $def) {
            if ($def->getTag(self::TAG_INJECT)) {
                $def = $def instanceof \_PhpScoperabd03f0baf05\Nette\DI\Definitions\FactoryDefinition ? $def->getResultDefinition() : $def;
                if ($def instanceof \_PhpScoperabd03f0baf05\Nette\DI\Definitions\ServiceDefinition) {
                    $this->updateDefinition($def);
                }
            }
        }
    }
    private function updateDefinition(\_PhpScoperabd03f0baf05\Nette\DI\Definitions\ServiceDefinition $def) : void
    {
        $resolvedType = (new \_PhpScoperabd03f0baf05\Nette\DI\Resolver($this->getContainerBuilder()))->resolveEntityType($def->getFactory());
        $class = \is_subclass_of($resolvedType, $def->getType()) ? $resolvedType : $def->getType();
        $setups = $def->getSetup();
        foreach (self::getInjectProperties($class) as $property => $type) {
            $builder = $this->getContainerBuilder();
            $inject = new \_PhpScoperabd03f0baf05\Nette\DI\Definitions\Statement('$' . $property, [\_PhpScoperabd03f0baf05\Nette\DI\Definitions\Reference::fromType((string) $type)]);
            foreach ($setups as $key => $setup) {
                if ($setup->getEntity() === $inject->getEntity()) {
                    $inject = $setup;
                    $builder = null;
                    unset($setups[$key]);
                }
            }
            self::checkType($class, $property, $type, $builder);
            \array_unshift($setups, $inject);
        }
        foreach (\array_reverse(self::getInjectMethods($class)) as $method) {
            $inject = new \_PhpScoperabd03f0baf05\Nette\DI\Definitions\Statement($method);
            foreach ($setups as $key => $setup) {
                if ($setup->getEntity() === $inject->getEntity()) {
                    $inject = $setup;
                    unset($setups[$key]);
                }
            }
            \array_unshift($setups, $inject);
        }
        $def->setSetup($setups);
    }
    /**
     * Generates list of inject methods.
     * @internal
     */
    public static function getInjectMethods(string $class) : array
    {
        $classes = [];
        foreach (\get_class_methods($class) as $name) {
            if (\substr($name, 0, 6) === 'inject') {
                $classes[$name] = (new \ReflectionMethod($class, $name))->getDeclaringClass()->name;
            }
        }
        $methods = \array_keys($classes);
        \uksort($classes, function (string $a, string $b) use($classes, $methods) : int {
            return $classes[$a] === $classes[$b] ? \array_search($a, $methods, \true) <=> \array_search($b, $methods, \true) : (\is_a($classes[$a], $classes[$b], \true) ? 1 : -1);
        });
        return \array_keys($classes);
    }
    /**
     * Generates list of properties with annotation @inject.
     * @internal
     */
    public static function getInjectProperties(string $class) : array
    {
        $res = [];
        foreach (\get_class_vars($class) as $name => $foo) {
            $rp = new \ReflectionProperty($class, $name);
            $hasAttr = \PHP_VERSION_ID >= 80000 && $rp->getAttributes(\_PhpScoperabd03f0baf05\Nette\DI\Attributes\Inject::class);
            if ($hasAttr || \_PhpScoperabd03f0baf05\Nette\DI\Helpers::parseAnnotation($rp, 'inject') !== null) {
                if ($type = \_PhpScoperabd03f0baf05\Nette\Utils\Reflection::getPropertyType($rp)) {
                } elseif (!$hasAttr && ($type = \_PhpScoperabd03f0baf05\Nette\DI\Helpers::parseAnnotation($rp, 'var'))) {
                    if (\strpos($type, '|') !== \false) {
                        throw new \_PhpScoperabd03f0baf05\Nette\InvalidStateException('The ' . \_PhpScoperabd03f0baf05\Nette\Utils\Reflection::toString($rp) . ' is not expected to have a union type.');
                    }
                    $type = \_PhpScoperabd03f0baf05\Nette\Utils\Reflection::expandClassName($type, \_PhpScoperabd03f0baf05\Nette\Utils\Reflection::getPropertyDeclaringClass($rp));
                }
                $res[$name] = $type;
            }
        }
        \ksort($res);
        return $res;
    }
    /**
     * Calls all methods starting with with "inject" using autowiring.
     * @param  object  $service
     */
    public static function callInjects(\_PhpScoperabd03f0baf05\Nette\DI\Container $container, $service) : void
    {
        if (!\is_object($service)) {
            throw new \_PhpScoperabd03f0baf05\Nette\InvalidArgumentException(\sprintf('Service must be object, %s given.', \gettype($service)));
        }
        foreach (self::getInjectMethods(\get_class($service)) as $method) {
            $container->callMethod([$service, $method]);
        }
        foreach (self::getInjectProperties(\get_class($service)) as $property => $type) {
            self::checkType($service, $property, $type, $container);
            $service->{$property} = $container->getByType($type);
        }
    }
    /**
     * @param  object|string  $class
     * @param  DI\Container|DI\ContainerBuilder|null  $container
     */
    private static function checkType($class, string $name, ?string $type, $container) : void
    {
        $propName = \_PhpScoperabd03f0baf05\Nette\Utils\Reflection::toString(new \ReflectionProperty($class, $name));
        if (!$type) {
            throw new \_PhpScoperabd03f0baf05\Nette\InvalidStateException("Property {$propName} has no type hint.");
        } elseif (!\class_exists($type) && !\interface_exists($type)) {
            throw new \_PhpScoperabd03f0baf05\Nette\InvalidStateException("Class or interface '{$type}' used in type hint at {$propName} not found. Check type and 'use' statements.");
        } elseif ($container && !$container->getByType($type, \false)) {
            throw new \_PhpScoperabd03f0baf05\Nette\DI\MissingServiceException("Service of type {$type} used in type hint at {$propName} not found. Did you add it to configuration file?");
        }
    }
}
