<?php

declare (strict_types=1);
namespace PHPStan\DependencyInjection\Reflection;

use PHPStan\Broker\Broker;
use PHPStan\Broker\BrokerFactory;
use PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension;
use PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension;
use PHPStan\Reflection\ClassReflectionExtensionRegistry;
use PHPStan\Reflection\Php\PhpClassReflectionExtension;
class LazyClassReflectionExtensionRegistryProvider implements \PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider
{
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var \PHPStan\Reflection\ClassReflectionExtensionRegistry|null */
    private $registry = null;
    public function __construct(\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \PHPStan\Reflection\ClassReflectionExtensionRegistry
    {
        if ($this->registry === null) {
            $phpClassReflectionExtension = $this->container->getByType(\PHPStan\Reflection\Php\PhpClassReflectionExtension::class);
            $annotationsMethodsClassReflectionExtension = $this->container->getByType(\PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension::class);
            $annotationsPropertiesClassReflectionExtension = $this->container->getByType(\PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension::class);
            $this->registry = new \PHPStan\Reflection\ClassReflectionExtensionRegistry($this->container->getByType(\PHPStan\Broker\Broker::class), \array_merge([$phpClassReflectionExtension], $this->container->getServicesByTag(\PHPStan\Broker\BrokerFactory::PROPERTIES_CLASS_REFLECTION_EXTENSION_TAG), [$annotationsPropertiesClassReflectionExtension]), \array_merge([$phpClassReflectionExtension], $this->container->getServicesByTag(\PHPStan\Broker\BrokerFactory::METHODS_CLASS_REFLECTION_EXTENSION_TAG), [$annotationsMethodsClassReflectionExtension]));
        }
        return $this->registry;
    }
}
