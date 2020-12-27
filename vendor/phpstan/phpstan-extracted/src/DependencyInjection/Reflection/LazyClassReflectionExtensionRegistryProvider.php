<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\DependencyInjection\Reflection;

use RectorPrefix20201227\PHPStan\Broker\Broker;
use RectorPrefix20201227\PHPStan\Broker\BrokerFactory;
use RectorPrefix20201227\PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension;
use RectorPrefix20201227\PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflectionExtensionRegistry;
use RectorPrefix20201227\PHPStan\Reflection\Php\PhpClassReflectionExtension;
class LazyClassReflectionExtensionRegistryProvider implements \RectorPrefix20201227\PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider
{
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var \PHPStan\Reflection\ClassReflectionExtensionRegistry|null */
    private $registry = null;
    public function __construct(\RectorPrefix20201227\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \RectorPrefix20201227\PHPStan\Reflection\ClassReflectionExtensionRegistry
    {
        if ($this->registry === null) {
            $phpClassReflectionExtension = $this->container->getByType(\RectorPrefix20201227\PHPStan\Reflection\Php\PhpClassReflectionExtension::class);
            $annotationsMethodsClassReflectionExtension = $this->container->getByType(\RectorPrefix20201227\PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension::class);
            $annotationsPropertiesClassReflectionExtension = $this->container->getByType(\RectorPrefix20201227\PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension::class);
            $this->registry = new \RectorPrefix20201227\PHPStan\Reflection\ClassReflectionExtensionRegistry($this->container->getByType(\RectorPrefix20201227\PHPStan\Broker\Broker::class), \array_merge([$phpClassReflectionExtension], $this->container->getServicesByTag(\RectorPrefix20201227\PHPStan\Broker\BrokerFactory::PROPERTIES_CLASS_REFLECTION_EXTENSION_TAG), [$annotationsPropertiesClassReflectionExtension]), \array_merge([$phpClassReflectionExtension], $this->container->getServicesByTag(\RectorPrefix20201227\PHPStan\Broker\BrokerFactory::METHODS_CLASS_REFLECTION_EXTENSION_TAG), [$annotationsMethodsClassReflectionExtension]));
        }
        return $this->registry;
    }
}
