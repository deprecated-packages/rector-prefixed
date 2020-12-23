<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\DependencyInjection;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\NodeScopeResolver;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\ScopeFactory;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifier;
use _PhpScoper0a2ac50786fa\PHPStan\Dependency\DependencyResolver;
use _PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\Container;
use _PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\ContainerFactory;
use _PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider;
use _PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider;
use _PhpScoper0a2ac50786fa\PHPStan\File\FileHelper;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDoc\TypeNodeResolver;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem;
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
        $smartFileSystem = new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem();
        $containerFactory = new \_PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\ContainerFactory($currentWorkingDirectory);
        $additionalConfigFiles = [];
        // possible path collision for Docker
        $additionalConfigFiles = $this->appendPhpstanPHPUnitExtensionIfExists($currentWorkingDirectory, $additionalConfigFiles);
        $temporaryPHPStanNeon = null;
        $currentProjectConfigFile = $currentWorkingDirectory . '/phpstan.neon';
        if (\file_exists($currentProjectConfigFile)) {
            $phpstanNeonContent = $smartFileSystem->readFile($currentProjectConfigFile);
            // bleeding edge clean out, see https://github.com/rectorphp/rector/issues/2431
            if (\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::match($phpstanNeonContent, self::BLEEDING_EDGE_REGEX)) {
                // Note: We need a unique file per process if rector runs in parallel
                $pid = \getmypid();
                $temporaryPHPStanNeon = $currentWorkingDirectory . '/rector-temp-phpstan' . $pid . '.neon';
                $clearedPhpstanNeonContent = \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::replace($phpstanNeonContent, self::BLEEDING_EDGE_REGEX, '');
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
    public function createReflectionProvider() : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider
    {
        return $this->container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider::class);
    }
    /**
     * @api
     */
    public function createNodeScopeResolver() : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\NodeScopeResolver
    {
        return $this->container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\NodeScopeResolver::class);
    }
    /**
     * @api
     */
    public function createTypeSpecifier() : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifier
    {
        return $this->container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifier::class);
    }
    /**
     * @api
     */
    public function createScopeFactory() : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\ScopeFactory
    {
        return $this->container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\ScopeFactory::class);
    }
    /**
     * @api
     */
    public function createDynamicReturnTypeExtensionRegistryProvider() : \_PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider
    {
        return $this->container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider::class);
    }
    /**
     * @api
     */
    public function createDependencyResolver() : \_PhpScoper0a2ac50786fa\PHPStan\Dependency\DependencyResolver
    {
        return $this->container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\Dependency\DependencyResolver::class);
    }
    /**
     * @api
     */
    public function createFileHelper() : \_PhpScoper0a2ac50786fa\PHPStan\File\FileHelper
    {
        return $this->container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\File\FileHelper::class);
    }
    /**
     * @api
     */
    public function createOperatorTypeSpecifyingExtensionRegistryProvider() : \_PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
    {
        return $this->container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider::class);
    }
    /**
     * @api
     */
    public function createTypeNodeResolver() : \_PhpScoper0a2ac50786fa\PHPStan\PhpDoc\TypeNodeResolver
    {
        return $this->container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\PhpDoc\TypeNodeResolver::class);
    }
    /**
     * @param string[] $additionalConfigFiles
     * @return mixed[]
     */
    private function appendPhpstanPHPUnitExtensionIfExists(string $currentWorkingDirectory, array $additionalConfigFiles) : array
    {
        $phpstanPhpunitExtensionConfig = $currentWorkingDirectory . '/vendor/phpstan/phpstan-phpunit/extension.neon';
        if (\file_exists($phpstanPhpunitExtensionConfig) && \class_exists('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase')) {
            $additionalConfigFiles[] = $phpstanPhpunitExtensionConfig;
        }
        return $additionalConfigFiles;
    }
}
