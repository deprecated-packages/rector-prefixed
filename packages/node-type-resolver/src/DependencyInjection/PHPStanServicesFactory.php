<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\DependencyInjection;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PHPStan\Analyser\NodeScopeResolver;
use _PhpScopere8e811afab72\PHPStan\Analyser\ScopeFactory;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifier;
use _PhpScopere8e811afab72\PHPStan\Dependency\DependencyResolver;
use _PhpScopere8e811afab72\PHPStan\DependencyInjection\Container;
use _PhpScopere8e811afab72\PHPStan\DependencyInjection\ContainerFactory;
use _PhpScopere8e811afab72\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider;
use _PhpScopere8e811afab72\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider;
use _PhpScopere8e811afab72\PHPStan\File\FileHelper;
use _PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolver;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
/**
 * Factory so Symfony app can use services from PHPStan container
 * @see packages/NodeTypeResolver/config/config.yaml:17
 */
final class PHPStanServicesFactory
{
    /**
     * @see https://regex101.com/r/CWADBe/2
     * @var string
     */
    private const BLEEDING_EDGE_REGEX = '#\\n\\s+-(.*?)bleedingEdge\\.neon[\'|"]?#';
    /**
     * @var Container
     */
    private $container;
    public function __construct()
    {
        $currentWorkingDirectory = \getcwd();
        $smartFileSystem = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem();
        $containerFactory = new \_PhpScopere8e811afab72\PHPStan\DependencyInjection\ContainerFactory($currentWorkingDirectory);
        $additionalConfigFiles = [];
        // possible path collision for Docker
        $additionalConfigFiles = $this->appendPhpstanPHPUnitExtensionIfExists($currentWorkingDirectory, $additionalConfigFiles);
        $temporaryPHPStanNeon = null;
        $currentProjectConfigFile = $currentWorkingDirectory . '/phpstan.neon';
        if (\file_exists($currentProjectConfigFile)) {
            $phpstanNeonContent = $smartFileSystem->readFile($currentProjectConfigFile);
            // bleeding edge clean out, see https://github.com/rectorphp/rector/issues/2431
            if (\_PhpScopere8e811afab72\Nette\Utils\Strings::match($phpstanNeonContent, self::BLEEDING_EDGE_REGEX)) {
                // Note: We need a unique file per process if rector runs in parallel
                $pid = \getmypid();
                $temporaryPHPStanNeon = $currentWorkingDirectory . '/rector-temp-phpstan' . $pid . '.neon';
                $clearedPhpstanNeonContent = \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($phpstanNeonContent, self::BLEEDING_EDGE_REGEX, '');
                $smartFileSystem->dumpFile($temporaryPHPStanNeon, $clearedPhpstanNeonContent);
                $additionalConfigFiles[] = $temporaryPHPStanNeon;
            } else {
                $additionalConfigFiles[] = $currentProjectConfigFile;
            }
        }
        $additionalConfigFiles[] = __DIR__ . '/../../config/phpstan/type-extensions.neon';
        // enable type inferring from constructor
        $additionalConfigFiles[] = __DIR__ . '/../../config/phpstan/better-infer.neon';
        $this->container = $containerFactory->create(\sys_get_temp_dir(), $additionalConfigFiles, []);
        // clear bleeding edge fallback
        if ($temporaryPHPStanNeon !== null) {
            $smartFileSystem->remove($temporaryPHPStanNeon);
        }
    }
    /**
     * @api
     */
    public function createReflectionProvider() : \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider
    {
        return $this->container->getByType(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider::class);
    }
    /**
     * @api
     */
    public function createNodeScopeResolver() : \_PhpScopere8e811afab72\PHPStan\Analyser\NodeScopeResolver
    {
        return $this->container->getByType(\_PhpScopere8e811afab72\PHPStan\Analyser\NodeScopeResolver::class);
    }
    /**
     * @api
     */
    public function createTypeSpecifier() : \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifier
    {
        return $this->container->getByType(\_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifier::class);
    }
    /**
     * @api
     */
    public function createScopeFactory() : \_PhpScopere8e811afab72\PHPStan\Analyser\ScopeFactory
    {
        return $this->container->getByType(\_PhpScopere8e811afab72\PHPStan\Analyser\ScopeFactory::class);
    }
    /**
     * @api
     */
    public function createDynamicReturnTypeExtensionRegistryProvider() : \_PhpScopere8e811afab72\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider
    {
        return $this->container->getByType(\_PhpScopere8e811afab72\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider::class);
    }
    /**
     * @api
     */
    public function createDependencyResolver() : \_PhpScopere8e811afab72\PHPStan\Dependency\DependencyResolver
    {
        return $this->container->getByType(\_PhpScopere8e811afab72\PHPStan\Dependency\DependencyResolver::class);
    }
    /**
     * @api
     */
    public function createFileHelper() : \_PhpScopere8e811afab72\PHPStan\File\FileHelper
    {
        return $this->container->getByType(\_PhpScopere8e811afab72\PHPStan\File\FileHelper::class);
    }
    /**
     * @api
     */
    public function createOperatorTypeSpecifyingExtensionRegistryProvider() : \_PhpScopere8e811afab72\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
    {
        return $this->container->getByType(\_PhpScopere8e811afab72\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider::class);
    }
    /**
     * @api
     */
    public function createTypeNodeResolver() : \_PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolver
    {
        return $this->container->getByType(\_PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolver::class);
    }
    /**
     * @param string[] $additionalConfigFiles
     * @return mixed[]
     */
    private function appendPhpstanPHPUnitExtensionIfExists(string $currentWorkingDirectory, array $additionalConfigFiles) : array
    {
        $phpstanPhpunitExtensionConfig = $currentWorkingDirectory . '/vendor/phpstan/phpstan-phpunit/extension.neon';
        if (\file_exists($phpstanPhpunitExtensionConfig) && \class_exists('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase')) {
            $additionalConfigFiles[] = $phpstanPhpunitExtensionConfig;
        }
        return $additionalConfigFiles;
    }
}
