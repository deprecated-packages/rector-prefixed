<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\DependencyInjection;

use _PhpScoperbd5d0c5f7638\Nette\Utils\Strings;
use PHPStan\Analyser\NodeScopeResolver;
use PHPStan\Analyser\ScopeFactory;
use PHPStan\Analyser\TypeSpecifier;
use PHPStan\Dependency\DependencyResolver;
use PHPStan\DependencyInjection\Container;
use PHPStan\DependencyInjection\ContainerFactory;
use PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider;
use PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider;
use PHPStan\File\FileHelper;
use PHPStan\PhpDoc\TypeNodeResolver;
use PHPStan\Reflection\ReflectionProvider;
use Symplify\SmartFileSystem\SmartFileSystem;
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
        $smartFileSystem = new \Symplify\SmartFileSystem\SmartFileSystem();
        $containerFactory = new \PHPStan\DependencyInjection\ContainerFactory($currentWorkingDirectory);
        $additionalConfigFiles = [];
        // possible path collision for Docker
        $additionalConfigFiles = $this->appendPhpstanPHPUnitExtensionIfExists($currentWorkingDirectory, $additionalConfigFiles);
        $temporaryPHPStanNeon = null;
        $currentProjectConfigFile = $currentWorkingDirectory . '/phpstan.neon';
        if (\file_exists($currentProjectConfigFile)) {
            $phpstanNeonContent = $smartFileSystem->readFile($currentProjectConfigFile);
            // bleeding edge clean out, see https://github.com/rectorphp/rector/issues/2431
            if (\_PhpScoperbd5d0c5f7638\Nette\Utils\Strings::match($phpstanNeonContent, self::BLEEDING_EDGE_REGEX)) {
                // Note: We need a unique file per process if rector runs in parallel
                $pid = \getmypid();
                $temporaryPHPStanNeon = $currentWorkingDirectory . '/rector-temp-phpstan' . $pid . '.neon';
                $clearedPhpstanNeonContent = \_PhpScoperbd5d0c5f7638\Nette\Utils\Strings::replace($phpstanNeonContent, self::BLEEDING_EDGE_REGEX);
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
    public function createReflectionProvider() : \PHPStan\Reflection\ReflectionProvider
    {
        return $this->container->getByType(\PHPStan\Reflection\ReflectionProvider::class);
    }
    /**
     * @api
     */
    public function createNodeScopeResolver() : \PHPStan\Analyser\NodeScopeResolver
    {
        return $this->container->getByType(\PHPStan\Analyser\NodeScopeResolver::class);
    }
    /**
     * @api
     */
    public function createTypeSpecifier() : \PHPStan\Analyser\TypeSpecifier
    {
        return $this->container->getByType(\PHPStan\Analyser\TypeSpecifier::class);
    }
    /**
     * @api
     */
    public function createScopeFactory() : \PHPStan\Analyser\ScopeFactory
    {
        return $this->container->getByType(\PHPStan\Analyser\ScopeFactory::class);
    }
    /**
     * @api
     */
    public function createDynamicReturnTypeExtensionRegistryProvider() : \PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider
    {
        return $this->container->getByType(\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider::class);
    }
    /**
     * @api
     */
    public function createDependencyResolver() : \PHPStan\Dependency\DependencyResolver
    {
        return $this->container->getByType(\PHPStan\Dependency\DependencyResolver::class);
    }
    /**
     * @api
     */
    public function createFileHelper() : \PHPStan\File\FileHelper
    {
        return $this->container->getByType(\PHPStan\File\FileHelper::class);
    }
    /**
     * @api
     */
    public function createOperatorTypeSpecifyingExtensionRegistryProvider() : \PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
    {
        return $this->container->getByType(\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider::class);
    }
    /**
     * @api
     */
    public function createTypeNodeResolver() : \PHPStan\PhpDoc\TypeNodeResolver
    {
        return $this->container->getByType(\PHPStan\PhpDoc\TypeNodeResolver::class);
    }
    /**
     * @param string[] $additionalConfigFiles
     * @return mixed[]
     */
    private function appendPhpstanPHPUnitExtensionIfExists(string $currentWorkingDirectory, array $additionalConfigFiles) : array
    {
        $phpstanPhpunitExtensionConfig = $currentWorkingDirectory . '/vendor/phpstan/phpstan-phpunit/extension.neon';
        if (\file_exists($phpstanPhpunitExtensionConfig) && \class_exists('_PhpScoperbd5d0c5f7638\\PHPUnit\\Framework\\TestCase')) {
            $additionalConfigFiles[] = $phpstanPhpunitExtensionConfig;
        }
        return $additionalConfigFiles;
    }
}
