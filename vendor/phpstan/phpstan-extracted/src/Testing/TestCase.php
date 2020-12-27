<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Testing;

use RectorPrefix20201227\Composer\Autoload\ClassLoader;
use PhpParser\PrettyPrinter\Standard;
use RectorPrefix20201227\PHPStan\Analyser\DirectScopeFactory;
use RectorPrefix20201227\PHPStan\Analyser\MutatingScope;
use RectorPrefix20201227\PHPStan\Analyser\NodeScopeResolver;
use RectorPrefix20201227\PHPStan\Analyser\ScopeFactory;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierFactory;
use RectorPrefix20201227\PHPStan\Broker\AnonymousClassNameHelper;
use RectorPrefix20201227\PHPStan\Broker\Broker;
use RectorPrefix20201227\PHPStan\Broker\BrokerFactory;
use RectorPrefix20201227\PHPStan\Cache\Cache;
use RectorPrefix20201227\PHPStan\Cache\MemoryCacheStorage;
use RectorPrefix20201227\PHPStan\DependencyInjection\Container;
use RectorPrefix20201227\PHPStan\DependencyInjection\ContainerFactory;
use RectorPrefix20201227\PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider;
use RectorPrefix20201227\PHPStan\DependencyInjection\Type\DirectDynamicReturnTypeExtensionRegistryProvider;
use RectorPrefix20201227\PHPStan\DependencyInjection\Type\DirectOperatorTypeSpecifyingExtensionRegistryProvider;
use RectorPrefix20201227\PHPStan\File\FileHelper;
use RectorPrefix20201227\PHPStan\File\SimpleRelativePathHelper;
use RectorPrefix20201227\PHPStan\Parser\CachedParser;
use RectorPrefix20201227\PHPStan\Parser\FunctionCallStatementFinder;
use RectorPrefix20201227\PHPStan\Parser\Parser;
use RectorPrefix20201227\PHPStan\Parser\PhpParserDecorator;
use RectorPrefix20201227\PHPStan\Php\PhpVersion;
use RectorPrefix20201227\PHPStan\PhpDoc\PhpDocInheritanceResolver;
use RectorPrefix20201227\PHPStan\PhpDoc\PhpDocNodeResolver;
use RectorPrefix20201227\PHPStan\PhpDoc\PhpDocStringResolver;
use RectorPrefix20201227\PHPStan\PhpDoc\StubPhpDocProvider;
use RectorPrefix20201227\PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension;
use RectorPrefix20201227\PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension;
use RectorPrefix20201227\PHPStan\Reflection\BetterReflection\BetterReflectionProvider;
use RectorPrefix20201227\PHPStan\Reflection\BetterReflection\Reflector\MemoizingClassReflector;
use RectorPrefix20201227\PHPStan\Reflection\BetterReflection\Reflector\MemoizingConstantReflector;
use RectorPrefix20201227\PHPStan\Reflection\BetterReflection\Reflector\MemoizingFunctionReflector;
use RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator;
use RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\ComposerJsonAndInstalledJsonSourceLocatorMaker;
use RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\FunctionReflectionFactory;
use RectorPrefix20201227\PHPStan\Reflection\Mixin\MixinMethodsClassReflectionExtension;
use RectorPrefix20201227\PHPStan\Reflection\Mixin\MixinPropertiesClassReflectionExtension;
use RectorPrefix20201227\PHPStan\Reflection\Php\PhpClassReflectionExtension;
use RectorPrefix20201227\PHPStan\Reflection\Php\PhpFunctionReflection;
use RectorPrefix20201227\PHPStan\Reflection\Php\PhpMethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\Php\PhpMethodReflectionFactory;
use RectorPrefix20201227\PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider\ClassBlacklistReflectionProvider;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider\ReflectionProviderFactory;
use RectorPrefix20201227\PHPStan\Reflection\Runtime\RuntimeReflectionProvider;
use RectorPrefix20201227\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider;
use RectorPrefix20201227\PHPStan\Reflection\SignatureMap\SignatureMapProvider;
use RectorPrefix20201227\PHPStan\Rules\Properties\PropertyReflectionFinder;
use PHPStan\Type\FileTypeMapper;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Php\SimpleXMLElementClassPropertyReflectionExtension;
use PHPStan\Type\Type;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ConstantReflector;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator;
abstract class TestCase extends \RectorPrefix20201227\PHPUnit\Framework\TestCase
{
    /** @var bool */
    public static $useStaticReflectionProvider = \false;
    /** @var array<string, Container> */
    private static $containers = [];
    /** @var DirectClassReflectionExtensionRegistryProvider|null */
    private $classReflectionExtensionRegistryProvider = null;
    /** @var array{ClassReflector, FunctionReflector, ConstantReflector}|null */
    private static $reflectors;
    /** @var PhpStormStubsSourceStubber|null */
    private static $phpStormStubsSourceStubber;
    public static function getContainer() : \RectorPrefix20201227\PHPStan\DependencyInjection\Container
    {
        $additionalConfigFiles = static::getAdditionalConfigFiles();
        $cacheKey = \sha1(\implode("\n", $additionalConfigFiles));
        if (!isset(self::$containers[$cacheKey])) {
            $tmpDir = \sys_get_temp_dir() . '/phpstan-tests';
            if (!@\mkdir($tmpDir, 0777) && !\is_dir($tmpDir)) {
                self::fail(\sprintf('Cannot create temp directory %s', $tmpDir));
            }
            if (self::$useStaticReflectionProvider) {
                $additionalConfigFiles[] = __DIR__ . '/TestCase-staticReflection.neon';
            }
            $rootDir = __DIR__ . '/../..';
            $containerFactory = new \RectorPrefix20201227\PHPStan\DependencyInjection\ContainerFactory($rootDir);
            self::$containers[$cacheKey] = $containerFactory->create($tmpDir, \array_merge([$containerFactory->getConfigDirectory() . '/config.level8.neon'], $additionalConfigFiles), []);
        }
        return self::$containers[$cacheKey];
    }
    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles() : array
    {
        return [];
    }
    public function getParser() : \RectorPrefix20201227\PHPStan\Parser\Parser
    {
        /** @var \PHPStan\Parser\Parser $parser */
        $parser = self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\Parser\CachedParser::class);
        return $parser;
    }
    /**
     * @param \PHPStan\Type\DynamicMethodReturnTypeExtension[] $dynamicMethodReturnTypeExtensions
     * @param \PHPStan\Type\DynamicStaticMethodReturnTypeExtension[] $dynamicStaticMethodReturnTypeExtensions
     * @return \PHPStan\Broker\Broker
     */
    public function createBroker(array $dynamicMethodReturnTypeExtensions = [], array $dynamicStaticMethodReturnTypeExtensions = []) : \RectorPrefix20201227\PHPStan\Broker\Broker
    {
        $dynamicReturnTypeExtensionRegistryProvider = new \RectorPrefix20201227\PHPStan\DependencyInjection\Type\DirectDynamicReturnTypeExtensionRegistryProvider(\array_merge(self::getContainer()->getServicesByTag(\RectorPrefix20201227\PHPStan\Broker\BrokerFactory::DYNAMIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $dynamicMethodReturnTypeExtensions, $this->getDynamicMethodReturnTypeExtensions()), \array_merge(self::getContainer()->getServicesByTag(\RectorPrefix20201227\PHPStan\Broker\BrokerFactory::DYNAMIC_STATIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $dynamicStaticMethodReturnTypeExtensions, $this->getDynamicStaticMethodReturnTypeExtensions()), \array_merge(self::getContainer()->getServicesByTag(\RectorPrefix20201227\PHPStan\Broker\BrokerFactory::DYNAMIC_FUNCTION_RETURN_TYPE_EXTENSION_TAG), $this->getDynamicFunctionReturnTypeExtensions()));
        $operatorTypeSpecifyingExtensionRegistryProvider = new \RectorPrefix20201227\PHPStan\DependencyInjection\Type\DirectOperatorTypeSpecifyingExtensionRegistryProvider($this->getOperatorTypeSpecifyingExtensions());
        $reflectionProvider = $this->createReflectionProvider();
        $broker = new \RectorPrefix20201227\PHPStan\Broker\Broker($reflectionProvider, $dynamicReturnTypeExtensionRegistryProvider, $operatorTypeSpecifyingExtensionRegistryProvider, self::getContainer()->getParameter('universalObjectCratesClasses'));
        $dynamicReturnTypeExtensionRegistryProvider->setBroker($broker);
        $dynamicReturnTypeExtensionRegistryProvider->setReflectionProvider($reflectionProvider);
        $operatorTypeSpecifyingExtensionRegistryProvider->setBroker($broker);
        $this->getClassReflectionExtensionRegistryProvider()->setBroker($broker);
        return $broker;
    }
    public function createReflectionProvider() : \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider
    {
        $staticReflectionProvider = $this->createStaticReflectionProvider();
        return $this->createReflectionProviderByParameters($this->createRuntimeReflectionProvider($staticReflectionProvider), $staticReflectionProvider, self::$useStaticReflectionProvider);
    }
    private function createReflectionProviderByParameters(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $runtimeReflectionProvider, \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $staticReflectionProvider, bool $disableRuntimeReflectionProvider) : \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider
    {
        $setterReflectionProviderProvider = new \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider();
        $reflectionProviderFactory = new \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider\ReflectionProviderFactory($runtimeReflectionProvider, $staticReflectionProvider, $disableRuntimeReflectionProvider);
        $reflectionProvider = $reflectionProviderFactory->create();
        $setterReflectionProviderProvider->setReflectionProvider($reflectionProvider);
        return $reflectionProvider;
    }
    private static function getPhpStormStubsSourceStubber() : \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber
    {
        if (self::$phpStormStubsSourceStubber === null) {
            self::$phpStormStubsSourceStubber = self::getContainer()->getByType(\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber::class);
        }
        return self::$phpStormStubsSourceStubber;
    }
    private function createRuntimeReflectionProvider(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $actualReflectionProvider) : \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider
    {
        $functionCallStatementFinder = new \RectorPrefix20201227\PHPStan\Parser\FunctionCallStatementFinder();
        $parser = $this->getParser();
        $cache = new \RectorPrefix20201227\PHPStan\Cache\Cache(new \RectorPrefix20201227\PHPStan\Cache\MemoryCacheStorage());
        $phpDocStringResolver = self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\PhpDoc\PhpDocStringResolver::class);
        $phpDocNodeResolver = self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\PhpDoc\PhpDocNodeResolver::class);
        $currentWorkingDirectory = $this->getCurrentWorkingDirectory();
        $fileHelper = new \RectorPrefix20201227\PHPStan\File\FileHelper($currentWorkingDirectory);
        $anonymousClassNameHelper = new \RectorPrefix20201227\PHPStan\Broker\AnonymousClassNameHelper(new \RectorPrefix20201227\PHPStan\File\FileHelper($currentWorkingDirectory), new \RectorPrefix20201227\PHPStan\File\SimpleRelativePathHelper($fileHelper->normalizePath($currentWorkingDirectory, '/')));
        $setterReflectionProviderProvider = new \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider();
        $fileTypeMapper = new \PHPStan\Type\FileTypeMapper($setterReflectionProviderProvider, $parser, $phpDocStringResolver, $phpDocNodeResolver, $cache, $anonymousClassNameHelper);
        $classReflectionExtensionRegistryProvider = $this->getClassReflectionExtensionRegistryProvider();
        $functionReflectionFactory = $this->getFunctionReflectionFactory($functionCallStatementFinder, $cache);
        $reflectionProvider = new \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider\ClassBlacklistReflectionProvider(new \RectorPrefix20201227\PHPStan\Reflection\Runtime\RuntimeReflectionProvider($setterReflectionProviderProvider, $classReflectionExtensionRegistryProvider, $functionReflectionFactory, $fileTypeMapper, self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\Php\PhpVersion::class), self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider::class), self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\PhpDoc\StubPhpDocProvider::class), self::getContainer()->getByType(\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber::class)), self::getPhpStormStubsSourceStubber(), ['#^PhpParser\\\\#', '#^PHPStan\\\\#', '#^Hoa\\\\#'], null);
        $this->setUpReflectionProvider($actualReflectionProvider, $setterReflectionProviderProvider, $classReflectionExtensionRegistryProvider, $functionCallStatementFinder, $parser, $cache, $fileTypeMapper);
        return $reflectionProvider;
    }
    private function setUpReflectionProvider(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $actualReflectionProvider, \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider $setterReflectionProviderProvider, \RectorPrefix20201227\PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider $classReflectionExtensionRegistryProvider, \RectorPrefix20201227\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \RectorPrefix20201227\PHPStan\Parser\Parser $parser, \RectorPrefix20201227\PHPStan\Cache\Cache $cache, \PHPStan\Type\FileTypeMapper $fileTypeMapper) : void
    {
        $methodReflectionFactory = new class($parser, $functionCallStatementFinder, $cache) implements \RectorPrefix20201227\PHPStan\Reflection\Php\PhpMethodReflectionFactory
        {
            /** @var \PHPStan\Parser\Parser */
            private $parser;
            /** @var \PHPStan\Parser\FunctionCallStatementFinder */
            private $functionCallStatementFinder;
            /** @var \PHPStan\Cache\Cache */
            private $cache;
            /** @var ReflectionProvider */
            public $reflectionProvider;
            public function __construct(\RectorPrefix20201227\PHPStan\Parser\Parser $parser, \RectorPrefix20201227\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \RectorPrefix20201227\PHPStan\Cache\Cache $cache)
            {
                $this->parser = $parser;
                $this->functionCallStatementFinder = $functionCallStatementFinder;
                $this->cache = $cache;
            }
            /**
             * @param ClassReflection $declaringClass
             * @param ClassReflection|null $declaringTrait
             * @param \PHPStan\Reflection\Php\BuiltinMethodReflection $reflection
             * @param TemplateTypeMap $templateTypeMap
             * @param Type[] $phpDocParameterTypes
             * @param Type|null $phpDocReturnType
             * @param Type|null $phpDocThrowType
             * @param string|null $deprecatedDescription
             * @param bool $isDeprecated
             * @param bool $isInternal
             * @param bool $isFinal
             * @param string|null $stubPhpDocString
             * @return PhpMethodReflection
             */
            public function create(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $declaringClass, ?\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $declaringTrait, \RectorPrefix20201227\PHPStan\Reflection\Php\BuiltinMethodReflection $reflection, \PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\PHPStan\Type\Type $phpDocReturnType, ?\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, ?string $stubPhpDocString) : \RectorPrefix20201227\PHPStan\Reflection\Php\PhpMethodReflection
            {
                return new \RectorPrefix20201227\PHPStan\Reflection\Php\PhpMethodReflection($declaringClass, $declaringTrait, $reflection, $this->reflectionProvider, $this->parser, $this->functionCallStatementFinder, $this->cache, $templateTypeMap, $phpDocParameterTypes, $phpDocReturnType, $phpDocThrowType, $deprecatedDescription, $isDeprecated, $isInternal, $isFinal, $stubPhpDocString);
            }
        };
        $phpDocInheritanceResolver = new \RectorPrefix20201227\PHPStan\PhpDoc\PhpDocInheritanceResolver($fileTypeMapper);
        $annotationsMethodsClassReflectionExtension = new \RectorPrefix20201227\PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension();
        $annotationsPropertiesClassReflectionExtension = new \RectorPrefix20201227\PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension();
        $signatureMapProvider = self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\Reflection\SignatureMap\SignatureMapProvider::class);
        $methodReflectionFactory->reflectionProvider = $actualReflectionProvider;
        $phpExtension = new \RectorPrefix20201227\PHPStan\Reflection\Php\PhpClassReflectionExtension(self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\Analyser\ScopeFactory::class), self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\Analyser\NodeScopeResolver::class), $methodReflectionFactory, $phpDocInheritanceResolver, $annotationsMethodsClassReflectionExtension, $annotationsPropertiesClassReflectionExtension, $signatureMapProvider, $parser, self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\PhpDoc\StubPhpDocProvider::class), $actualReflectionProvider, $fileTypeMapper, \true, []);
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension($phpExtension);
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension(new \RectorPrefix20201227\PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension([\stdClass::class]));
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension(new \RectorPrefix20201227\PHPStan\Reflection\Mixin\MixinPropertiesClassReflectionExtension([]));
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension(new \PHPStan\Type\Php\SimpleXMLElementClassPropertyReflectionExtension());
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension($annotationsPropertiesClassReflectionExtension);
        $classReflectionExtensionRegistryProvider->addMethodsClassReflectionExtension($phpExtension);
        $classReflectionExtensionRegistryProvider->addMethodsClassReflectionExtension(new \RectorPrefix20201227\PHPStan\Reflection\Mixin\MixinMethodsClassReflectionExtension([]));
        $classReflectionExtensionRegistryProvider->addMethodsClassReflectionExtension($annotationsMethodsClassReflectionExtension);
        $setterReflectionProviderProvider->setReflectionProvider($actualReflectionProvider);
    }
    private function createStaticReflectionProvider() : \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider
    {
        $parser = $this->getParser();
        $phpDocStringResolver = self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\PhpDoc\PhpDocStringResolver::class);
        $phpDocNodeResolver = self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\PhpDoc\PhpDocNodeResolver::class);
        $currentWorkingDirectory = $this->getCurrentWorkingDirectory();
        $cache = new \RectorPrefix20201227\PHPStan\Cache\Cache(new \RectorPrefix20201227\PHPStan\Cache\MemoryCacheStorage());
        $fileHelper = new \RectorPrefix20201227\PHPStan\File\FileHelper($currentWorkingDirectory);
        $relativePathHelper = new \RectorPrefix20201227\PHPStan\File\SimpleRelativePathHelper($currentWorkingDirectory);
        $anonymousClassNameHelper = new \RectorPrefix20201227\PHPStan\Broker\AnonymousClassNameHelper($fileHelper, new \RectorPrefix20201227\PHPStan\File\SimpleRelativePathHelper($fileHelper->normalizePath($currentWorkingDirectory, '/')));
        $setterReflectionProviderProvider = new \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider();
        $fileTypeMapper = new \PHPStan\Type\FileTypeMapper($setterReflectionProviderProvider, $parser, $phpDocStringResolver, $phpDocNodeResolver, $cache, $anonymousClassNameHelper);
        $functionCallStatementFinder = new \RectorPrefix20201227\PHPStan\Parser\FunctionCallStatementFinder();
        $functionReflectionFactory = $this->getFunctionReflectionFactory($functionCallStatementFinder, $cache);
        [$classReflector, $functionReflector, $constantReflector] = self::getReflectors();
        $classReflectionExtensionRegistryProvider = $this->getClassReflectionExtensionRegistryProvider();
        $reflectionProvider = new \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\BetterReflectionProvider($setterReflectionProviderProvider, $classReflectionExtensionRegistryProvider, $classReflector, $fileTypeMapper, self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\Php\PhpVersion::class), self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider::class), self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\PhpDoc\StubPhpDocProvider::class), $functionReflectionFactory, $relativePathHelper, $anonymousClassNameHelper, self::getContainer()->getByType(\PhpParser\PrettyPrinter\Standard::class), $fileHelper, $functionReflector, $constantReflector);
        $this->setUpReflectionProvider($reflectionProvider, $setterReflectionProviderProvider, $classReflectionExtensionRegistryProvider, $functionCallStatementFinder, $parser, $cache, $fileTypeMapper);
        return $reflectionProvider;
    }
    /**
     * @return array{ClassReflector, FunctionReflector, ConstantReflector}
     */
    public static function getReflectors() : array
    {
        if (self::$reflectors !== null) {
            return self::$reflectors;
        }
        if (!\class_exists(\RectorPrefix20201227\Composer\Autoload\ClassLoader::class)) {
            self::fail('Composer ClassLoader is unknown');
        }
        $classLoaderReflection = new \ReflectionClass(\RectorPrefix20201227\Composer\Autoload\ClassLoader::class);
        if ($classLoaderReflection->getFileName() === \false) {
            self::fail('Unknown ClassLoader filename');
        }
        $composerProjectPath = \dirname($classLoaderReflection->getFileName(), 3);
        if (!\is_file($composerProjectPath . '/composer.json')) {
            self::fail(\sprintf('composer.json not found in directory %s', $composerProjectPath));
        }
        $composerJsonAndInstalledJsonSourceLocatorMaker = self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\ComposerJsonAndInstalledJsonSourceLocatorMaker::class);
        $composerSourceLocator = $composerJsonAndInstalledJsonSourceLocatorMaker->create($composerProjectPath);
        if ($composerSourceLocator === null) {
            self::fail('Could not create composer source locator');
        }
        // these need to be synced with TestCase-staticReflection.neon file and TestCaseSourceLocatorFactory
        $locators = [$composerSourceLocator];
        $phpParser = new \RectorPrefix20201227\PHPStan\Parser\PhpParserDecorator(self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\Parser\CachedParser::class));
        /** @var FunctionReflector $functionReflector */
        $functionReflector = null;
        $astLocator = new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator($phpParser, static function () use(&$functionReflector) : FunctionReflector {
            return $functionReflector;
        });
        $reflectionSourceStubber = new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber();
        $locators[] = new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, self::getPhpStormStubsSourceStubber());
        $locators[] = new \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator(self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher::class));
        $locators[] = new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, $reflectionSourceStubber);
        $locators[] = new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator($astLocator, $reflectionSourceStubber);
        $sourceLocator = new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator(new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator($locators));
        $classReflector = new \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\Reflector\MemoizingClassReflector($sourceLocator);
        $functionReflector = new \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\Reflector\MemoizingFunctionReflector($sourceLocator, $classReflector);
        $constantReflector = new \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\Reflector\MemoizingConstantReflector($sourceLocator, $classReflector);
        self::$reflectors = [$classReflector, $functionReflector, $constantReflector];
        return self::$reflectors;
    }
    private function getFunctionReflectionFactory(\RectorPrefix20201227\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \RectorPrefix20201227\PHPStan\Cache\Cache $cache) : \RectorPrefix20201227\PHPStan\Reflection\FunctionReflectionFactory
    {
        return new class($this->getParser(), $functionCallStatementFinder, $cache) implements \RectorPrefix20201227\PHPStan\Reflection\FunctionReflectionFactory
        {
            /** @var \PHPStan\Parser\Parser */
            private $parser;
            /** @var \PHPStan\Parser\FunctionCallStatementFinder */
            private $functionCallStatementFinder;
            /** @var \PHPStan\Cache\Cache */
            private $cache;
            public function __construct(\RectorPrefix20201227\PHPStan\Parser\Parser $parser, \RectorPrefix20201227\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \RectorPrefix20201227\PHPStan\Cache\Cache $cache)
            {
                $this->parser = $parser;
                $this->functionCallStatementFinder = $functionCallStatementFinder;
                $this->cache = $cache;
            }
            /**
             * @param \ReflectionFunction $function
             * @param TemplateTypeMap $templateTypeMap
             * @param Type[] $phpDocParameterTypes
             * @param Type|null $phpDocReturnType
             * @param Type|null $phpDocThrowType
             * @param string|null $deprecatedDescription
             * @param bool $isDeprecated
             * @param bool $isInternal
             * @param bool $isFinal
             * @param string|false $filename
             * @return PhpFunctionReflection
             */
            public function create(\ReflectionFunction $function, \PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\PHPStan\Type\Type $phpDocReturnType, ?\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, $filename) : \RectorPrefix20201227\PHPStan\Reflection\Php\PhpFunctionReflection
            {
                return new \RectorPrefix20201227\PHPStan\Reflection\Php\PhpFunctionReflection($function, $this->parser, $this->functionCallStatementFinder, $this->cache, $templateTypeMap, $phpDocParameterTypes, $phpDocReturnType, $phpDocThrowType, $deprecatedDescription, $isDeprecated, $isInternal, $isFinal, $filename);
            }
        };
    }
    public function getClassReflectionExtensionRegistryProvider() : \RectorPrefix20201227\PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider
    {
        if ($this->classReflectionExtensionRegistryProvider === null) {
            $this->classReflectionExtensionRegistryProvider = new \RectorPrefix20201227\PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider([], []);
        }
        return $this->classReflectionExtensionRegistryProvider;
    }
    public function createScopeFactory(\RectorPrefix20201227\PHPStan\Broker\Broker $broker, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : \RectorPrefix20201227\PHPStan\Analyser\ScopeFactory
    {
        $container = self::getContainer();
        return new \RectorPrefix20201227\PHPStan\Analyser\DirectScopeFactory(\RectorPrefix20201227\PHPStan\Analyser\MutatingScope::class, $broker, $broker->getDynamicReturnTypeExtensionRegistryProvider(), $broker->getOperatorTypeSpecifyingExtensionRegistryProvider(), new \PhpParser\PrettyPrinter\Standard(), $typeSpecifier, new \RectorPrefix20201227\PHPStan\Rules\Properties\PropertyReflectionFinder(), $this->getParser(), $this->shouldTreatPhpDocTypesAsCertain(), $container);
    }
    protected function shouldTreatPhpDocTypesAsCertain() : bool
    {
        return \true;
    }
    public function getCurrentWorkingDirectory() : string
    {
        return $this->getFileHelper()->normalizePath(__DIR__ . '/../..');
    }
    /**
     * @return \PHPStan\Type\DynamicMethodReturnTypeExtension[]
     */
    public function getDynamicMethodReturnTypeExtensions() : array
    {
        return [];
    }
    /**
     * @return \PHPStan\Type\DynamicStaticMethodReturnTypeExtension[]
     */
    public function getDynamicStaticMethodReturnTypeExtensions() : array
    {
        return [];
    }
    /**
     * @return \PHPStan\Type\DynamicFunctionReturnTypeExtension[]
     */
    public function getDynamicFunctionReturnTypeExtensions() : array
    {
        return [];
    }
    /**
     * @return \PHPStan\Type\OperatorTypeSpecifyingExtension[]
     */
    public function getOperatorTypeSpecifyingExtensions() : array
    {
        return [];
    }
    /**
     * @param \PhpParser\PrettyPrinter\Standard $printer
     * @param \PHPStan\Reflection\ReflectionProvider $reflectionProvider
     * @param \PHPStan\Type\MethodTypeSpecifyingExtension[] $methodTypeSpecifyingExtensions
     * @param \PHPStan\Type\StaticMethodTypeSpecifyingExtension[] $staticMethodTypeSpecifyingExtensions
     * @return \PHPStan\Analyser\TypeSpecifier
     */
    public function createTypeSpecifier(\PhpParser\PrettyPrinter\Standard $printer, \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $reflectionProvider, array $methodTypeSpecifyingExtensions = [], array $staticMethodTypeSpecifyingExtensions = []) : \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier
    {
        return new \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier($printer, $reflectionProvider, self::getContainer()->getServicesByTag(\RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierFactory::FUNCTION_TYPE_SPECIFYING_EXTENSION_TAG), $methodTypeSpecifyingExtensions, $staticMethodTypeSpecifyingExtensions);
    }
    public function getFileHelper() : \RectorPrefix20201227\PHPStan\File\FileHelper
    {
        return self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\File\FileHelper::class);
    }
    /**
     * Provides a DIRECTORY_SEPARATOR agnostic assertion helper, to compare file paths.
     *
     * @param string $expected
     * @param string $actual
     * @param string $message
     */
    protected function assertSamePaths(string $expected, string $actual, string $message = '') : void
    {
        $expected = $this->getFileHelper()->normalizePath($expected);
        $actual = $this->getFileHelper()->normalizePath($actual);
        $this->assertSame($expected, $actual, $message);
    }
    protected function skipIfNotOnWindows() : void
    {
        if (\DIRECTORY_SEPARATOR === '\\') {
            return;
        }
        self::markTestSkipped();
    }
    protected function skipIfNotOnUnix() : void
    {
        if (\DIRECTORY_SEPARATOR === '/') {
            return;
        }
        self::markTestSkipped();
    }
}
