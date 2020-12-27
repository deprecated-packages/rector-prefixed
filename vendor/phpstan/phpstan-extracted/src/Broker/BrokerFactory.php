<?php

declare (strict_types=1);
namespace PHPStan\Broker;

use PHPStan\DependencyInjection\Container;
use PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider;
use PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider;
use PHPStan\Reflection\ReflectionProvider;
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
    public function __construct(\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function create() : \PHPStan\Broker\Broker
    {
        return new \PHPStan\Broker\Broker($this->container->getByType(\PHPStan\Reflection\ReflectionProvider::class), $this->container->getByType(\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider::class), $this->container->getByType(\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider::class), $this->container->getParameter('universalObjectCratesClasses'));
    }
}
