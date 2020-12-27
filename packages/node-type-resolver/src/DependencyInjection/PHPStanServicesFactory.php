<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\DependencyInjection;

use RectorPrefix20201227\PHPStan\Analyser\NodeScopeResolver;
use RectorPrefix20201227\PHPStan\Analyser\ScopeFactory;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier;
use RectorPrefix20201227\PHPStan\Dependency\DependencyResolver;
use RectorPrefix20201227\PHPStan\DependencyInjection\Container;
use RectorPrefix20201227\PHPStan\DependencyInjection\ContainerFactory;
use RectorPrefix20201227\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider;
use RectorPrefix20201227\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider;
use RectorPrefix20201227\PHPStan\File\FileHelper;
use RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolver;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use Rector\Core\Configuration\Option;
use RectorPrefix20201227\Symplify\PackageBuilder\Parameter\ParameterProvider;
/**
 * Factory so Symfony app can use services from PHPStan container
 * @see packages/NodeTypeResolver/config/config.yaml:17
 */
final class PHPStanServicesFactory
{
    /**
     * @var Container
     */
    private $container;
    public function __construct(\RectorPrefix20201227\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $containerFactory = new \RectorPrefix20201227\PHPStan\DependencyInjection\ContainerFactory(\getcwd());
        $additionalConfigFiles = [];
        $additionalConfigFiles[] = $parameterProvider->provideStringParameter(\Rector\Core\Configuration\Option::PHPSTAN_FOR_RECTOR_PATH);
        $additionalConfigFiles[] = \getcwd() . '/vendor/phpstan/phpstan-phpunit/extension.neon';
        // enable type inferring from constructor
        $additionalConfigFiles[] = __DIR__ . '/../../config/phpstan/better-infer.neon';
        // symplify phpstan extensions
        $additionalConfigFiles[] = \getcwd() . '/vendor/symplify/phpstan-extensions/config/config.neon';
        $existingAdditionalConfigFiles = \array_filter($additionalConfigFiles, 'file_exists');
        $this->container = $containerFactory->create(\sys_get_temp_dir(), $existingAdditionalConfigFiles, []);
    }
    /**
     * @api
     */
    public function createReflectionProvider() : \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider
    {
        return $this->container->getByType(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider::class);
    }
    /**
     * @api
     */
    public function createNodeScopeResolver() : \RectorPrefix20201227\PHPStan\Analyser\NodeScopeResolver
    {
        return $this->container->getByType(\RectorPrefix20201227\PHPStan\Analyser\NodeScopeResolver::class);
    }
    /**
     * @api
     */
    public function createTypeSpecifier() : \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier
    {
        return $this->container->getByType(\RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier::class);
    }
    /**
     * @api
     */
    public function createScopeFactory() : \RectorPrefix20201227\PHPStan\Analyser\ScopeFactory
    {
        return $this->container->getByType(\RectorPrefix20201227\PHPStan\Analyser\ScopeFactory::class);
    }
    /**
     * @api
     */
    public function createDynamicReturnTypeExtensionRegistryProvider() : \RectorPrefix20201227\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider
    {
        return $this->container->getByType(\RectorPrefix20201227\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider::class);
    }
    /**
     * @api
     */
    public function createDependencyResolver() : \RectorPrefix20201227\PHPStan\Dependency\DependencyResolver
    {
        return $this->container->getByType(\RectorPrefix20201227\PHPStan\Dependency\DependencyResolver::class);
    }
    /**
     * @api
     */
    public function createFileHelper() : \RectorPrefix20201227\PHPStan\File\FileHelper
    {
        return $this->container->getByType(\RectorPrefix20201227\PHPStan\File\FileHelper::class);
    }
    /**
     * @api
     */
    public function createOperatorTypeSpecifyingExtensionRegistryProvider() : \RectorPrefix20201227\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
    {
        return $this->container->getByType(\RectorPrefix20201227\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider::class);
    }
    /**
     * @api
     */
    public function createTypeNodeResolver() : \RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolver
    {
        return $this->container->getByType(\RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolver::class);
    }
}
