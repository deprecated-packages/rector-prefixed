<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\DependencyInjection\Reflection;

use _PhpScopere8e811afab72\PHPStan\Broker\Broker;
use _PhpScopere8e811afab72\PHPStan\Broker\BrokerFactory;
use _PhpScopere8e811afab72\PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension;
use _PhpScopere8e811afab72\PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflectionExtensionRegistry;
use _PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpClassReflectionExtension;
class LazyClassReflectionExtensionRegistryProvider implements \_PhpScopere8e811afab72\PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider
{
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var \PHPStan\Reflection\ClassReflectionExtensionRegistry|null */
    private $registry = null;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflectionExtensionRegistry
    {
        if ($this->registry === null) {
            $phpClassReflectionExtension = $this->container->getByType(\_PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpClassReflectionExtension::class);
            $annotationsMethodsClassReflectionExtension = $this->container->getByType(\_PhpScopere8e811afab72\PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension::class);
            $annotationsPropertiesClassReflectionExtension = $this->container->getByType(\_PhpScopere8e811afab72\PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension::class);
            $this->registry = new \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflectionExtensionRegistry($this->container->getByType(\_PhpScopere8e811afab72\PHPStan\Broker\Broker::class), \array_merge([$phpClassReflectionExtension], $this->container->getServicesByTag(\_PhpScopere8e811afab72\PHPStan\Broker\BrokerFactory::PROPERTIES_CLASS_REFLECTION_EXTENSION_TAG), [$annotationsPropertiesClassReflectionExtension]), \array_merge([$phpClassReflectionExtension], $this->container->getServicesByTag(\_PhpScopere8e811afab72\PHPStan\Broker\BrokerFactory::METHODS_CLASS_REFLECTION_EXTENSION_TAG), [$annotationsMethodsClassReflectionExtension]));
        }
        return $this->registry;
    }
}
