<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Testing;

use _PhpScoper0a6b37af0871\Composer\Autoload\ClassLoader;
use _PhpScoper0a6b37af0871\PhpParser\PrettyPrinter\Standard;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\DirectScopeFactory;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\MutatingScope;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\NodeScopeResolver;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\ScopeFactory;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifier;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierFactory;
use _PhpScoper0a6b37af0871\PHPStan\Broker\AnonymousClassNameHelper;
use _PhpScoper0a6b37af0871\PHPStan\Broker\Broker;
use _PhpScoper0a6b37af0871\PHPStan\Broker\BrokerFactory;
use _PhpScoper0a6b37af0871\PHPStan\Cache\Cache;
use _PhpScoper0a6b37af0871\PHPStan\Cache\MemoryCacheStorage;
use _PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Container;
use _PhpScoper0a6b37af0871\PHPStan\DependencyInjection\ContainerFactory;
use _PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider;
use _PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Type\DirectDynamicReturnTypeExtensionRegistryProvider;
use _PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Type\DirectOperatorTypeSpecifyingExtensionRegistryProvider;
use _PhpScoper0a6b37af0871\PHPStan\File\FileHelper;
use _PhpScoper0a6b37af0871\PHPStan\File\SimpleRelativePathHelper;
use _PhpScoper0a6b37af0871\PHPStan\Parser\CachedParser;
use _PhpScoper0a6b37af0871\PHPStan\Parser\FunctionCallStatementFinder;
use _PhpScoper0a6b37af0871\PHPStan\Parser\Parser;
use _PhpScoper0a6b37af0871\PHPStan\Parser\PhpParserDecorator;
use _PhpScoper0a6b37af0871\PHPStan\Php\PhpVersion;
use _PhpScoper0a6b37af0871\PHPStan\PhpDoc\PhpDocInheritanceResolver;
use _PhpScoper0a6b37af0871\PHPStan\PhpDoc\PhpDocNodeResolver;
use _PhpScoper0a6b37af0871\PHPStan\PhpDoc\PhpDocStringResolver;
use _PhpScoper0a6b37af0871\PHPStan\PhpDoc\StubPhpDocProvider;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\BetterReflection\BetterReflectionProvider;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\BetterReflection\Reflector\MemoizingClassReflector;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\BetterReflection\Reflector\MemoizingConstantReflector;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\BetterReflection\Reflector\MemoizingFunctionReflector;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\BetterReflection\SourceLocator\ComposerJsonAndInstalledJsonSourceLocatorMaker;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflectionFactory;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\Mixin\MixinMethodsClassReflectionExtension;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\Mixin\MixinPropertiesClassReflectionExtension;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\Php\PhpClassReflectionExtension;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\Php\PhpFunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\Php\PhpMethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\Php\PhpMethodReflectionFactory;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider\ClassBlacklistReflectionProvider;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider\ReflectionProviderFactory;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\Runtime\RuntimeReflectionProvider;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\SignatureMap\SignatureMapProvider;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Properties\PropertyReflectionFinder;
use _PhpScoper0a6b37af0871\PHPStan\Type\FileTypeMapper;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper0a6b37af0871\PHPStan\Type\Php\SimpleXMLElementClassPropertyReflectionExtension;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ConstantReflector;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator;
abstract class TestCase extends \_PhpScoper0a6b37af0871\PHPUnit\Framework\TestCase
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
    public static function getContainer() : \_PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Container
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
            $containerFactory = new \_PhpScoper0a6b37af0871\PHPStan\DependencyInjection\ContainerFactory($rootDir);
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
    public function getParser() : \_PhpScoper0a6b37af0871\PHPStan\Parser\Parser
    {
        /** @var \PHPStan\Parser\Parser $parser */
        $parser = self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\Parser\CachedParser::class);
        return $parser;
    }
    /**
     * @param \PHPStan\Type\DynamicMethodReturnTypeExtension[] $dynamicMethodReturnTypeExtensions
     * @param \PHPStan\Type\DynamicStaticMethodReturnTypeExtension[] $dynamicStaticMethodReturnTypeExtensions
     * @return \PHPStan\Broker\Broker
     */
    public function createBroker(array $dynamicMethodReturnTypeExtensions = [], array $dynamicStaticMethodReturnTypeExtensions = []) : \_PhpScoper0a6b37af0871\PHPStan\Broker\Broker
    {
        $dynamicReturnTypeExtensionRegistryProvider = new \_PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Type\DirectDynamicReturnTypeExtensionRegistryProvider(\array_merge(self::getContainer()->getServicesByTag(\_PhpScoper0a6b37af0871\PHPStan\Broker\BrokerFactory::DYNAMIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $dynamicMethodReturnTypeExtensions, $this->getDynamicMethodReturnTypeExtensions()), \array_merge(self::getContainer()->getServicesByTag(\_PhpScoper0a6b37af0871\PHPStan\Broker\BrokerFactory::DYNAMIC_STATIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $dynamicStaticMethodReturnTypeExtensions, $this->getDynamicStaticMethodReturnTypeExtensions()), \array_merge(self::getContainer()->getServicesByTag(\_PhpScoper0a6b37af0871\PHPStan\Broker\BrokerFactory::DYNAMIC_FUNCTION_RETURN_TYPE_EXTENSION_TAG), $this->getDynamicFunctionReturnTypeExtensions()));
        $operatorTypeSpecifyingExtensionRegistryProvider = new \_PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Type\DirectOperatorTypeSpecifyingExtensionRegistryProvider($this->getOperatorTypeSpecifyingExtensions());
        $reflectionProvider = $this->createReflectionProvider();
        $broker = new \_PhpScoper0a6b37af0871\PHPStan\Broker\Broker($reflectionProvider, $dynamicReturnTypeExtensionRegistryProvider, $operatorTypeSpecifyingExtensionRegistryProvider, self::getContainer()->getParameter('universalObjectCratesClasses'));
        $dynamicReturnTypeExtensionRegistryProvider->setBroker($broker);
        $dynamicReturnTypeExtensionRegistryProvider->setReflectionProvider($reflectionProvider);
        $operatorTypeSpecifyingExtensionRegistryProvider->setBroker($broker);
        $this->getClassReflectionExtensionRegistryProvider()->setBroker($broker);
        return $broker;
    }
    public function createReflectionProvider() : \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider
    {
        $staticReflectionProvider = $this->createStaticReflectionProvider();
        return $this->createReflectionProviderByParameters($this->createRuntimeReflectionProvider($staticReflectionProvider), $staticReflectionProvider, self::$useStaticReflectionProvider);
    }
    private function createReflectionProviderByParameters(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider $runtimeReflectionProvider, \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider $staticReflectionProvider, bool $disableRuntimeReflectionProvider) : \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider
    {
        $setterReflectionProviderProvider = new \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider();
        $reflectionProviderFactory = new \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider\ReflectionProviderFactory($runtimeReflectionProvider, $staticReflectionProvider, $disableRuntimeReflectionProvider);
        $reflectionProvider = $reflectionProviderFactory->create();
        $setterReflectionProviderProvider->setReflectionProvider($reflectionProvider);
        return $reflectionProvider;
    }
    private static function getPhpStormStubsSourceStubber() : \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber
    {
        if (self::$phpStormStubsSourceStubber === null) {
            self::$phpStormStubsSourceStubber = self::getContainer()->getByType(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber::class);
        }
        return self::$phpStormStubsSourceStubber;
    }
    private function createRuntimeReflectionProvider(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider $actualReflectionProvider) : \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider
    {
        $functionCallStatementFinder = new \_PhpScoper0a6b37af0871\PHPStan\Parser\FunctionCallStatementFinder();
        $parser = $this->getParser();
        $cache = new \_PhpScoper0a6b37af0871\PHPStan\Cache\Cache(new \_PhpScoper0a6b37af0871\PHPStan\Cache\MemoryCacheStorage());
        $phpDocStringResolver = self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\PhpDoc\PhpDocStringResolver::class);
        $phpDocNodeResolver = self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\PhpDoc\PhpDocNodeResolver::class);
        $currentWorkingDirectory = $this->getCurrentWorkingDirectory();
        $fileHelper = new \_PhpScoper0a6b37af0871\PHPStan\File\FileHelper($currentWorkingDirectory);
        $anonymousClassNameHelper = new \_PhpScoper0a6b37af0871\PHPStan\Broker\AnonymousClassNameHelper(new \_PhpScoper0a6b37af0871\PHPStan\File\FileHelper($currentWorkingDirectory), new \_PhpScoper0a6b37af0871\PHPStan\File\SimpleRelativePathHelper($fileHelper->normalizePath($currentWorkingDirectory, '/')));
        $setterReflectionProviderProvider = new \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider();
        $fileTypeMapper = new \_PhpScoper0a6b37af0871\PHPStan\Type\FileTypeMapper($setterReflectionProviderProvider, $parser, $phpDocStringResolver, $phpDocNodeResolver, $cache, $anonymousClassNameHelper);
        $classReflectionExtensionRegistryProvider = $this->getClassReflectionExtensionRegistryProvider();
        $functionReflectionFactory = $this->getFunctionReflectionFactory($functionCallStatementFinder, $cache);
        $reflectionProvider = new \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider\ClassBlacklistReflectionProvider(new \_PhpScoper0a6b37af0871\PHPStan\Reflection\Runtime\RuntimeReflectionProvider($setterReflectionProviderProvider, $classReflectionExtensionRegistryProvider, $functionReflectionFactory, $fileTypeMapper, self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\Php\PhpVersion::class), self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider::class), self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\PhpDoc\StubPhpDocProvider::class), self::getContainer()->getByType(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber::class)), self::getPhpStormStubsSourceStubber(), ['#^PhpParser\\\\#', '#^PHPStan\\\\#', '#^Hoa\\\\#'], null);
        $this->setUpReflectionProvider($actualReflectionProvider, $setterReflectionProviderProvider, $classReflectionExtensionRegistryProvider, $functionCallStatementFinder, $parser, $cache, $fileTypeMapper);
        return $reflectionProvider;
    }
    private function setUpReflectionProvider(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider $actualReflectionProvider, \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider $setterReflectionProviderProvider, \_PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider $classReflectionExtensionRegistryProvider, \_PhpScoper0a6b37af0871\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \_PhpScoper0a6b37af0871\PHPStan\Parser\Parser $parser, \_PhpScoper0a6b37af0871\PHPStan\Cache\Cache $cache, \_PhpScoper0a6b37af0871\PHPStan\Type\FileTypeMapper $fileTypeMapper) : void
    {
        $methodReflectionFactory = new class($parser, $functionCallStatementFinder, $cache) implements \_PhpScoper0a6b37af0871\PHPStan\Reflection\Php\PhpMethodReflectionFactory
        {
            /** @var \PHPStan\Parser\Parser */
            private $parser;
            /** @var \PHPStan\Parser\FunctionCallStatementFinder */
            private $functionCallStatementFinder;
            /** @var \PHPStan\Cache\Cache */
            private $cache;
            /** @var ReflectionProvider */
            public $reflectionProvider;
            public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Parser\Parser $parser, \_PhpScoper0a6b37af0871\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \_PhpScoper0a6b37af0871\PHPStan\Cache\Cache $cache)
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
            public function create(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection $declaringClass, ?\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection $declaringTrait, \_PhpScoper0a6b37af0871\PHPStan\Reflection\Php\BuiltinMethodReflection $reflection, \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $phpDocReturnType, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, ?string $stubPhpDocString) : \_PhpScoper0a6b37af0871\PHPStan\Reflection\Php\PhpMethodReflection
            {
                return new \_PhpScoper0a6b37af0871\PHPStan\Reflection\Php\PhpMethodReflection($declaringClass, $declaringTrait, $reflection, $this->reflectionProvider, $this->parser, $this->functionCallStatementFinder, $this->cache, $templateTypeMap, $phpDocParameterTypes, $phpDocReturnType, $phpDocThrowType, $deprecatedDescription, $isDeprecated, $isInternal, $isFinal, $stubPhpDocString);
            }
        };
        $phpDocInheritanceResolver = new \_PhpScoper0a6b37af0871\PHPStan\PhpDoc\PhpDocInheritanceResolver($fileTypeMapper);
        $annotationsMethodsClassReflectionExtension = new \_PhpScoper0a6b37af0871\PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension();
        $annotationsPropertiesClassReflectionExtension = new \_PhpScoper0a6b37af0871\PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension();
        $signatureMapProvider = self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\Reflection\SignatureMap\SignatureMapProvider::class);
        $methodReflectionFactory->reflectionProvider = $actualReflectionProvider;
        $phpExtension = new \_PhpScoper0a6b37af0871\PHPStan\Reflection\Php\PhpClassReflectionExtension(self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\Analyser\ScopeFactory::class), self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\Analyser\NodeScopeResolver::class), $methodReflectionFactory, $phpDocInheritanceResolver, $annotationsMethodsClassReflectionExtension, $annotationsPropertiesClassReflectionExtension, $signatureMapProvider, $parser, self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\PhpDoc\StubPhpDocProvider::class), $actualReflectionProvider, $fileTypeMapper, \true, []);
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension($phpExtension);
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension(new \_PhpScoper0a6b37af0871\PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension([\stdClass::class]));
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension(new \_PhpScoper0a6b37af0871\PHPStan\Reflection\Mixin\MixinPropertiesClassReflectionExtension([]));
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension(new \_PhpScoper0a6b37af0871\PHPStan\Type\Php\SimpleXMLElementClassPropertyReflectionExtension());
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension($annotationsPropertiesClassReflectionExtension);
        $classReflectionExtensionRegistryProvider->addMethodsClassReflectionExtension($phpExtension);
        $classReflectionExtensionRegistryProvider->addMethodsClassReflectionExtension(new \_PhpScoper0a6b37af0871\PHPStan\Reflection\Mixin\MixinMethodsClassReflectionExtension([]));
        $classReflectionExtensionRegistryProvider->addMethodsClassReflectionExtension($annotationsMethodsClassReflectionExtension);
        $setterReflectionProviderProvider->setReflectionProvider($actualReflectionProvider);
    }
    private function createStaticReflectionProvider() : \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider
    {
        $parser = $this->getParser();
        $phpDocStringResolver = self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\PhpDoc\PhpDocStringResolver::class);
        $phpDocNodeResolver = self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\PhpDoc\PhpDocNodeResolver::class);
        $currentWorkingDirectory = $this->getCurrentWorkingDirectory();
        $cache = new \_PhpScoper0a6b37af0871\PHPStan\Cache\Cache(new \_PhpScoper0a6b37af0871\PHPStan\Cache\MemoryCacheStorage());
        $fileHelper = new \_PhpScoper0a6b37af0871\PHPStan\File\FileHelper($currentWorkingDirectory);
        $relativePathHelper = new \_PhpScoper0a6b37af0871\PHPStan\File\SimpleRelativePathHelper($currentWorkingDirectory);
        $anonymousClassNameHelper = new \_PhpScoper0a6b37af0871\PHPStan\Broker\AnonymousClassNameHelper($fileHelper, new \_PhpScoper0a6b37af0871\PHPStan\File\SimpleRelativePathHelper($fileHelper->normalizePath($currentWorkingDirectory, '/')));
        $setterReflectionProviderProvider = new \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider();
        $fileTypeMapper = new \_PhpScoper0a6b37af0871\PHPStan\Type\FileTypeMapper($setterReflectionProviderProvider, $parser, $phpDocStringResolver, $phpDocNodeResolver, $cache, $anonymousClassNameHelper);
        $functionCallStatementFinder = new \_PhpScoper0a6b37af0871\PHPStan\Parser\FunctionCallStatementFinder();
        $functionReflectionFactory = $this->getFunctionReflectionFactory($functionCallStatementFinder, $cache);
        [$classReflector, $functionReflector, $constantReflector] = self::getReflectors();
        $classReflectionExtensionRegistryProvider = $this->getClassReflectionExtensionRegistryProvider();
        $reflectionProvider = new \_PhpScoper0a6b37af0871\PHPStan\Reflection\BetterReflection\BetterReflectionProvider($setterReflectionProviderProvider, $classReflectionExtensionRegistryProvider, $classReflector, $fileTypeMapper, self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\Php\PhpVersion::class), self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider::class), self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\PhpDoc\StubPhpDocProvider::class), $functionReflectionFactory, $relativePathHelper, $anonymousClassNameHelper, self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PhpParser\PrettyPrinter\Standard::class), $fileHelper, $functionReflector, $constantReflector);
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
        if (!\class_exists(\_PhpScoper0a6b37af0871\Composer\Autoload\ClassLoader::class)) {
            self::fail('Composer ClassLoader is unknown');
        }
        $classLoaderReflection = new \ReflectionClass(\_PhpScoper0a6b37af0871\Composer\Autoload\ClassLoader::class);
        if ($classLoaderReflection->getFileName() === \false) {
            self::fail('Unknown ClassLoader filename');
        }
        $composerProjectPath = \dirname($classLoaderReflection->getFileName(), 3);
        if (!\is_file($composerProjectPath . '/composer.json')) {
            self::fail(\sprintf('composer.json not found in directory %s', $composerProjectPath));
        }
        $composerJsonAndInstalledJsonSourceLocatorMaker = self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\Reflection\BetterReflection\SourceLocator\ComposerJsonAndInstalledJsonSourceLocatorMaker::class);
        $composerSourceLocator = $composerJsonAndInstalledJsonSourceLocatorMaker->create($composerProjectPath);
        if ($composerSourceLocator === null) {
            self::fail('Could not create composer source locator');
        }
        // these need to be synced with TestCase-staticReflection.neon file and TestCaseSourceLocatorFactory
        $locators = [$composerSourceLocator];
        $phpParser = new \_PhpScoper0a6b37af0871\PHPStan\Parser\PhpParserDecorator(self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\Parser\CachedParser::class));
        /** @var FunctionReflector $functionReflector */
        $functionReflector = null;
        $astLocator = new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator($phpParser, static function () use(&$functionReflector) : FunctionReflector {
            return $functionReflector;
        });
        $reflectionSourceStubber = new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber();
        $locators[] = new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, self::getPhpStormStubsSourceStubber());
        $locators[] = new \_PhpScoper0a6b37af0871\PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator(self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher::class));
        $locators[] = new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, $reflectionSourceStubber);
        $locators[] = new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator($astLocator, $reflectionSourceStubber);
        $sourceLocator = new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator(new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator($locators));
        $classReflector = new \_PhpScoper0a6b37af0871\PHPStan\Reflection\BetterReflection\Reflector\MemoizingClassReflector($sourceLocator);
        $functionReflector = new \_PhpScoper0a6b37af0871\PHPStan\Reflection\BetterReflection\Reflector\MemoizingFunctionReflector($sourceLocator, $classReflector);
        $constantReflector = new \_PhpScoper0a6b37af0871\PHPStan\Reflection\BetterReflection\Reflector\MemoizingConstantReflector($sourceLocator, $classReflector);
        self::$reflectors = [$classReflector, $functionReflector, $constantReflector];
        return self::$reflectors;
    }
    private function getFunctionReflectionFactory(\_PhpScoper0a6b37af0871\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \_PhpScoper0a6b37af0871\PHPStan\Cache\Cache $cache) : \_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflectionFactory
    {
        return new class($this->getParser(), $functionCallStatementFinder, $cache) implements \_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflectionFactory
        {
            /** @var \PHPStan\Parser\Parser */
            private $parser;
            /** @var \PHPStan\Parser\FunctionCallStatementFinder */
            private $functionCallStatementFinder;
            /** @var \PHPStan\Cache\Cache */
            private $cache;
            public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Parser\Parser $parser, \_PhpScoper0a6b37af0871\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \_PhpScoper0a6b37af0871\PHPStan\Cache\Cache $cache)
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
            public function create(\ReflectionFunction $function, \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $phpDocReturnType, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, $filename) : \_PhpScoper0a6b37af0871\PHPStan\Reflection\Php\PhpFunctionReflection
            {
                return new \_PhpScoper0a6b37af0871\PHPStan\Reflection\Php\PhpFunctionReflection($function, $this->parser, $this->functionCallStatementFinder, $this->cache, $templateTypeMap, $phpDocParameterTypes, $phpDocReturnType, $phpDocThrowType, $deprecatedDescription, $isDeprecated, $isInternal, $isFinal, $filename);
            }
        };
    }
    public function getClassReflectionExtensionRegistryProvider() : \_PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider
    {
        if ($this->classReflectionExtensionRegistryProvider === null) {
            $this->classReflectionExtensionRegistryProvider = new \_PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider([], []);
        }
        return $this->classReflectionExtensionRegistryProvider;
    }
    public function createScopeFactory(\_PhpScoper0a6b37af0871\PHPStan\Broker\Broker $broker, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : \_PhpScoper0a6b37af0871\PHPStan\Analyser\ScopeFactory
    {
        $container = self::getContainer();
        return new \_PhpScoper0a6b37af0871\PHPStan\Analyser\DirectScopeFactory(\_PhpScoper0a6b37af0871\PHPStan\Analyser\MutatingScope::class, $broker, $broker->getDynamicReturnTypeExtensionRegistryProvider(), $broker->getOperatorTypeSpecifyingExtensionRegistryProvider(), new \_PhpScoper0a6b37af0871\PhpParser\PrettyPrinter\Standard(), $typeSpecifier, new \_PhpScoper0a6b37af0871\PHPStan\Rules\Properties\PropertyReflectionFinder(), $this->getParser(), $this->shouldTreatPhpDocTypesAsCertain(), $container);
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
    public function createTypeSpecifier(\_PhpScoper0a6b37af0871\PhpParser\PrettyPrinter\Standard $printer, \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider $reflectionProvider, array $methodTypeSpecifyingExtensions = [], array $staticMethodTypeSpecifyingExtensions = []) : \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifier
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifier($printer, $reflectionProvider, self::getContainer()->getServicesByTag(\_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierFactory::FUNCTION_TYPE_SPECIFYING_EXTENSION_TAG), $methodTypeSpecifyingExtensions, $staticMethodTypeSpecifyingExtensions);
    }
    public function getFileHelper() : \_PhpScoper0a6b37af0871\PHPStan\File\FileHelper
    {
        return self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\File\FileHelper::class);
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
