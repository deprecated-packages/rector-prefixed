<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Analyser;

use PhpParser\PrettyPrinter\Standard;
use RectorPrefix20201227\PHPStan\Broker\BrokerFactory;
use RectorPrefix20201227\PHPStan\DependencyInjection\Container;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
class TypeSpecifierFactory
{
    public const FUNCTION_TYPE_SPECIFYING_EXTENSION_TAG = 'phpstan.typeSpecifier.functionTypeSpecifyingExtension';
    public const METHOD_TYPE_SPECIFYING_EXTENSION_TAG = 'phpstan.typeSpecifier.methodTypeSpecifyingExtension';
    public const STATIC_METHOD_TYPE_SPECIFYING_EXTENSION_TAG = 'phpstan.typeSpecifier.staticMethodTypeSpecifyingExtension';
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    public function __construct(\RectorPrefix20201227\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function create() : \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier
    {
        $typeSpecifier = new \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier($this->container->getByType(\PhpParser\PrettyPrinter\Standard::class), $this->container->getByType(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider::class), $this->container->getServicesByTag(self::FUNCTION_TYPE_SPECIFYING_EXTENSION_TAG), $this->container->getServicesByTag(self::METHOD_TYPE_SPECIFYING_EXTENSION_TAG), $this->container->getServicesByTag(self::STATIC_METHOD_TYPE_SPECIFYING_EXTENSION_TAG));
        foreach (\array_merge($this->container->getServicesByTag(\RectorPrefix20201227\PHPStan\Broker\BrokerFactory::PROPERTIES_CLASS_REFLECTION_EXTENSION_TAG), $this->container->getServicesByTag(\RectorPrefix20201227\PHPStan\Broker\BrokerFactory::METHODS_CLASS_REFLECTION_EXTENSION_TAG), $this->container->getServicesByTag(\RectorPrefix20201227\PHPStan\Broker\BrokerFactory::DYNAMIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $this->container->getServicesByTag(\RectorPrefix20201227\PHPStan\Broker\BrokerFactory::DYNAMIC_STATIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $this->container->getServicesByTag(\RectorPrefix20201227\PHPStan\Broker\BrokerFactory::DYNAMIC_FUNCTION_RETURN_TYPE_EXTENSION_TAG)) as $extension) {
            if (!$extension instanceof \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierAwareExtension) {
                continue;
            }
            $extension->setTypeSpecifier($typeSpecifier);
        }
        return $typeSpecifier;
    }
}
