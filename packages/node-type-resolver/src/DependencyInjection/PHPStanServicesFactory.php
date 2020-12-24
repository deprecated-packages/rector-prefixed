<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\DependencyInjection;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NodeScopeResolver;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\ScopeFactory;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifier;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Dependency\DependencyResolver;
use _PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\Container;
use _PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\ContainerFactory;
use _PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider;
use _PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider;
use _PhpScoper2a4e7ab1ecbc\PHPStan\File\FileHelper;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeNodeResolver;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Configuration\Option;
use _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Parameter\ParameterProvider;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $containerFactory = new \_PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\ContainerFactory(\getcwd());
        $additionalConfigFiles = [];
        $additionalConfigFiles[] = $parameterProvider->provideStringParameter(\_PhpScoper2a4e7ab1ecbc\Rector\Core\Configuration\Option::PHPSTAN_FOR_RECTOR_PATH);
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
    public function createReflectionProvider() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider
    {
        return $this->container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider::class);
    }
    /**
     * @api
     */
    public function createNodeScopeResolver() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NodeScopeResolver
    {
        return $this->container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NodeScopeResolver::class);
    }
    /**
     * @api
     */
    public function createTypeSpecifier() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifier
    {
        return $this->container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifier::class);
    }
    /**
     * @api
     */
    public function createScopeFactory() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\ScopeFactory
    {
        return $this->container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\ScopeFactory::class);
    }
    /**
     * @api
     */
    public function createDynamicReturnTypeExtensionRegistryProvider() : \_PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider
    {
        return $this->container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider::class);
    }
    /**
     * @api
     */
    public function createDependencyResolver() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Dependency\DependencyResolver
    {
        return $this->container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Dependency\DependencyResolver::class);
    }
    /**
     * @api
     */
    public function createFileHelper() : \_PhpScoper2a4e7ab1ecbc\PHPStan\File\FileHelper
    {
        return $this->container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\File\FileHelper::class);
    }
    /**
     * @api
     */
    public function createOperatorTypeSpecifyingExtensionRegistryProvider() : \_PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
    {
        return $this->container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider::class);
    }
    /**
     * @api
     */
    public function createTypeNodeResolver() : \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeNodeResolver
    {
        return $this->container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeNodeResolver::class);
    }
}
