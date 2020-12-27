<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Broker;

use RectorPrefix20201227\PHPStan\DependencyInjection\Container;
use RectorPrefix20201227\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider;
use RectorPrefix20201227\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
class BrokerFactory
{
    public const PROPERTIES_CLASS_REFLECTION_EXTENSION_TAG = 'phpstan.broker.propertiesClassReflectionExtension';
    public const METHODS_CLASS_REFLECTION_EXTENSION_TAG = 'phpstan.broker.methodsClassReflectionExtension';
    public const DYNAMIC_METHOD_RETURN_TYPE_EXTENSION_TAG = 'phpstan.broker.dynamicMethodReturnTypeExtension';
    public const DYNAMIC_STATIC_METHOD_RETURN_TYPE_EXTENSION_TAG = 'phpstan.broker.dynamicStaticMethodReturnTypeExtension';
    public const DYNAMIC_FUNCTION_RETURN_TYPE_EXTENSION_TAG = 'phpstan.broker.dynamicFunctionReturnTypeExtension';
    public const OPERATOR_TYPE_SPECIFYING_EXTENSION_TAG = 'phpstan.broker.operatorTypeSpecifyingExtension';
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    public function __construct(\RectorPrefix20201227\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function create() : \RectorPrefix20201227\PHPStan\Broker\Broker
    {
        return new \RectorPrefix20201227\PHPStan\Broker\Broker($this->container->getByType(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider::class), $this->container->getByType(\RectorPrefix20201227\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider::class), $this->container->getByType(\RectorPrefix20201227\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider::class), $this->container->getParameter('universalObjectCratesClasses'));
    }
}
