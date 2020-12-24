<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Testing;

use _PhpScoperb75b35f52b74\Composer\Autoload\ClassLoader;
use _PhpScoperb75b35f52b74\PhpParser\PrettyPrinter\Standard;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\DirectScopeFactory;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\MutatingScope;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\NodeScopeResolver;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\ScopeFactory;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifier;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierFactory;
use _PhpScoperb75b35f52b74\PHPStan\Broker\AnonymousClassNameHelper;
use _PhpScoperb75b35f52b74\PHPStan\Broker\Broker;
use _PhpScoperb75b35f52b74\PHPStan\Broker\BrokerFactory;
use _PhpScoperb75b35f52b74\PHPStan\Cache\Cache;
use _PhpScoperb75b35f52b74\PHPStan\Cache\MemoryCacheStorage;
use _PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Container;
use _PhpScoperb75b35f52b74\PHPStan\DependencyInjection\ContainerFactory;
use _PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider;
use _PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Type\DirectDynamicReturnTypeExtensionRegistryProvider;
use _PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Type\DirectOperatorTypeSpecifyingExtensionRegistryProvider;
use _PhpScoperb75b35f52b74\PHPStan\File\FileHelper;
use _PhpScoperb75b35f52b74\PHPStan\File\SimpleRelativePathHelper;
use _PhpScoperb75b35f52b74\PHPStan\Parser\CachedParser;
use _PhpScoperb75b35f52b74\PHPStan\Parser\FunctionCallStatementFinder;
use _PhpScoperb75b35f52b74\PHPStan\Parser\Parser;
use _PhpScoperb75b35f52b74\PHPStan\Parser\PhpParserDecorator;
use _PhpScoperb75b35f52b74\PHPStan\Php\PhpVersion;
use _PhpScoperb75b35f52b74\PHPStan\PhpDoc\PhpDocInheritanceResolver;
use _PhpScoperb75b35f52b74\PHPStan\PhpDoc\PhpDocNodeResolver;
use _PhpScoperb75b35f52b74\PHPStan\PhpDoc\PhpDocStringResolver;
use _PhpScoperb75b35f52b74\PHPStan\PhpDoc\StubPhpDocProvider;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\BetterReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\Reflector\MemoizingClassReflector;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\Reflector\MemoizingConstantReflector;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\Reflector\MemoizingFunctionReflector;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\SourceLocator\ComposerJsonAndInstalledJsonSourceLocatorMaker;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflectionFactory;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Mixin\MixinMethodsClassReflectionExtension;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Mixin\MixinPropertiesClassReflectionExtension;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpClassReflectionExtension;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpFunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpMethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpMethodReflectionFactory;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider\ClassBlacklistReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider\ReflectionProviderFactory;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Runtime\RuntimeReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\SignatureMap\SignatureMapProvider;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Properties\PropertyReflectionFinder;
use _PhpScoperb75b35f52b74\PHPStan\Type\FileTypeMapper;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoperb75b35f52b74\PHPStan\Type\Php\SimpleXMLElementClassPropertyReflectionExtension;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ConstantReflector;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator;
abstract class TestCase extends \_PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase
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
    public static function getContainer() : \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Container
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
            $containerFactory = new \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\ContainerFactory($rootDir);
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
    public function getParser() : \_PhpScoperb75b35f52b74\PHPStan\Parser\Parser
    {
        /** @var \PHPStan\Parser\Parser $parser */
        $parser = self::getContainer()->getByType(\_PhpScoperb75b35f52b74\PHPStan\Parser\CachedParser::class);
        return $parser;
    }
    /**
     * @param \PHPStan\Type\DynamicMethodReturnTypeExtension[] $dynamicMethodReturnTypeExtensions
     * @param \PHPStan\Type\DynamicStaticMethodReturnTypeExtension[] $dynamicStaticMethodReturnTypeExtensions
     * @return \PHPStan\Broker\Broker
     */
    public function createBroker(array $dynamicMethodReturnTypeExtensions = [], array $dynamicStaticMethodReturnTypeExtensions = []) : \_PhpScoperb75b35f52b74\PHPStan\Broker\Broker
    {
        $dynamicReturnTypeExtensionRegistryProvider = new \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Type\DirectDynamicReturnTypeExtensionRegistryProvider(\array_merge(self::getContainer()->getServicesByTag(\_PhpScoperb75b35f52b74\PHPStan\Broker\BrokerFactory::DYNAMIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $dynamicMethodReturnTypeExtensions, $this->getDynamicMethodReturnTypeExtensions()), \array_merge(self::getContainer()->getServicesByTag(\_PhpScoperb75b35f52b74\PHPStan\Broker\BrokerFactory::DYNAMIC_STATIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $dynamicStaticMethodReturnTypeExtensions, $this->getDynamicStaticMethodReturnTypeExtensions()), \array_merge(self::getContainer()->getServicesByTag(\_PhpScoperb75b35f52b74\PHPStan\Broker\BrokerFactory::DYNAMIC_FUNCTION_RETURN_TYPE_EXTENSION_TAG), $this->getDynamicFunctionReturnTypeExtensions()));
        $operatorTypeSpecifyingExtensionRegistryProvider = new \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Type\DirectOperatorTypeSpecifyingExtensionRegistryProvider($this->getOperatorTypeSpecifyingExtensions());
        $reflectionProvider = $this->createReflectionProvider();
        $broker = new \_PhpScoperb75b35f52b74\PHPStan\Broker\Broker($reflectionProvider, $dynamicReturnTypeExtensionRegistryProvider, $operatorTypeSpecifyingExtensionRegistryProvider, self::getContainer()->getParameter('universalObjectCratesClasses'));
        $dynamicReturnTypeExtensionRegistryProvider->setBroker($broker);
        $dynamicReturnTypeExtensionRegistryProvider->setReflectionProvider($reflectionProvider);
        $operatorTypeSpecifyingExtensionRegistryProvider->setBroker($broker);
        $this->getClassReflectionExtensionRegistryProvider()->setBroker($broker);
        return $broker;
    }
    public function createReflectionProvider() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider
    {
        $staticReflectionProvider = $this->createStaticReflectionProvider();
        return $this->createReflectionProviderByParameters($this->createRuntimeReflectionProvider($staticReflectionProvider), $staticReflectionProvider, self::$useStaticReflectionProvider);
    }
    private function createReflectionProviderByParameters(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $runtimeReflectionProvider, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $staticReflectionProvider, bool $disableRuntimeReflectionProvider) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider
    {
        $setterReflectionProviderProvider = new \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider();
        $reflectionProviderFactory = new \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider\ReflectionProviderFactory($runtimeReflectionProvider, $staticReflectionProvider, $disableRuntimeReflectionProvider);
        $reflectionProvider = $reflectionProviderFactory->create();
        $setterReflectionProviderProvider->setReflectionProvider($reflectionProvider);
        return $reflectionProvider;
    }
    private static function getPhpStormStubsSourceStubber() : \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber
    {
        if (self::$phpStormStubsSourceStubber === null) {
            self::$phpStormStubsSourceStubber = self::getContainer()->getByType(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber::class);
        }
        return self::$phpStormStubsSourceStubber;
    }
    private function createRuntimeReflectionProvider(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $actualReflectionProvider) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider
    {
        $functionCallStatementFinder = new \_PhpScoperb75b35f52b74\PHPStan\Parser\FunctionCallStatementFinder();
        $parser = $this->getParser();
        $cache = new \_PhpScoperb75b35f52b74\PHPStan\Cache\Cache(new \_PhpScoperb75b35f52b74\PHPStan\Cache\MemoryCacheStorage());
        $phpDocStringResolver = self::getContainer()->getByType(\_PhpScoperb75b35f52b74\PHPStan\PhpDoc\PhpDocStringResolver::class);
        $phpDocNodeResolver = self::getContainer()->getByType(\_PhpScoperb75b35f52b74\PHPStan\PhpDoc\PhpDocNodeResolver::class);
        $currentWorkingDirectory = $this->getCurrentWorkingDirectory();
        $fileHelper = new \_PhpScoperb75b35f52b74\PHPStan\File\FileHelper($currentWorkingDirectory);
        $anonymousClassNameHelper = new \_PhpScoperb75b35f52b74\PHPStan\Broker\AnonymousClassNameHelper(new \_PhpScoperb75b35f52b74\PHPStan\File\FileHelper($currentWorkingDirectory), new \_PhpScoperb75b35f52b74\PHPStan\File\SimpleRelativePathHelper($fileHelper->normalizePath($currentWorkingDirectory, '/')));
        $setterReflectionProviderProvider = new \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider();
        $fileTypeMapper = new \_PhpScoperb75b35f52b74\PHPStan\Type\FileTypeMapper($setterReflectionProviderProvider, $parser, $phpDocStringResolver, $phpDocNodeResolver, $cache, $anonymousClassNameHelper);
        $classReflectionExtensionRegistryProvider = $this->getClassReflectionExtensionRegistryProvider();
        $functionReflectionFactory = $this->getFunctionReflectionFactory($functionCallStatementFinder, $cache);
        $reflectionProvider = new \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider\ClassBlacklistReflectionProvider(new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Runtime\RuntimeReflectionProvider($setterReflectionProviderProvider, $classReflectionExtensionRegistryProvider, $functionReflectionFactory, $fileTypeMapper, self::getContainer()->getByType(\_PhpScoperb75b35f52b74\PHPStan\Php\PhpVersion::class), self::getContainer()->getByType(\_PhpScoperb75b35f52b74\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider::class), self::getContainer()->getByType(\_PhpScoperb75b35f52b74\PHPStan\PhpDoc\StubPhpDocProvider::class), self::getContainer()->getByType(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber::class)), self::getPhpStormStubsSourceStubber(), ['#^PhpParser\\\\#', '#^PHPStan\\\\#', '#^Hoa\\\\#'], null);
        $this->setUpReflectionProvider($actualReflectionProvider, $setterReflectionProviderProvider, $classReflectionExtensionRegistryProvider, $functionCallStatementFinder, $parser, $cache, $fileTypeMapper);
        return $reflectionProvider;
    }
    private function setUpReflectionProvider(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $actualReflectionProvider, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider $setterReflectionProviderProvider, \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider $classReflectionExtensionRegistryProvider, \_PhpScoperb75b35f52b74\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \_PhpScoperb75b35f52b74\PHPStan\Parser\Parser $parser, \_PhpScoperb75b35f52b74\PHPStan\Cache\Cache $cache, \_PhpScoperb75b35f52b74\PHPStan\Type\FileTypeMapper $fileTypeMapper) : void
    {
        $methodReflectionFactory = new class($parser, $functionCallStatementFinder, $cache) implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpMethodReflectionFactory
        {
            /** @var \PHPStan\Parser\Parser */
            private $parser;
            /** @var \PHPStan\Parser\FunctionCallStatementFinder */
            private $functionCallStatementFinder;
            /** @var \PHPStan\Cache\Cache */
            private $cache;
            /** @var ReflectionProvider */
            public $reflectionProvider;
            public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Parser\Parser $parser, \_PhpScoperb75b35f52b74\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \_PhpScoperb75b35f52b74\PHPStan\Cache\Cache $cache)
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
            public function create(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $declaringClass, ?\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $declaringTrait, \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\BuiltinMethodReflection $reflection, \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $phpDocReturnType, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, ?string $stubPhpDocString) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpMethodReflection
            {
                return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpMethodReflection($declaringClass, $declaringTrait, $reflection, $this->reflectionProvider, $this->parser, $this->functionCallStatementFinder, $this->cache, $templateTypeMap, $phpDocParameterTypes, $phpDocReturnType, $phpDocThrowType, $deprecatedDescription, $isDeprecated, $isInternal, $isFinal, $stubPhpDocString);
            }
        };
        $phpDocInheritanceResolver = new \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\PhpDocInheritanceResolver($fileTypeMapper);
        $annotationsMethodsClassReflectionExtension = new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension();
        $annotationsPropertiesClassReflectionExtension = new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension();
        $signatureMapProvider = self::getContainer()->getByType(\_PhpScoperb75b35f52b74\PHPStan\Reflection\SignatureMap\SignatureMapProvider::class);
        $methodReflectionFactory->reflectionProvider = $actualReflectionProvider;
        $phpExtension = new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpClassReflectionExtension(self::getContainer()->getByType(\_PhpScoperb75b35f52b74\PHPStan\Analyser\ScopeFactory::class), self::getContainer()->getByType(\_PhpScoperb75b35f52b74\PHPStan\Analyser\NodeScopeResolver::class), $methodReflectionFactory, $phpDocInheritanceResolver, $annotationsMethodsClassReflectionExtension, $annotationsPropertiesClassReflectionExtension, $signatureMapProvider, $parser, self::getContainer()->getByType(\_PhpScoperb75b35f52b74\PHPStan\PhpDoc\StubPhpDocProvider::class), $actualReflectionProvider, $fileTypeMapper, \true, []);
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension($phpExtension);
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension(new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension([\stdClass::class]));
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension(new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Mixin\MixinPropertiesClassReflectionExtension([]));
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension(new \_PhpScoperb75b35f52b74\PHPStan\Type\Php\SimpleXMLElementClassPropertyReflectionExtension());
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension($annotationsPropertiesClassReflectionExtension);
        $classReflectionExtensionRegistryProvider->addMethodsClassReflectionExtension($phpExtension);
        $classReflectionExtensionRegistryProvider->addMethodsClassReflectionExtension(new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Mixin\MixinMethodsClassReflectionExtension([]));
        $classReflectionExtensionRegistryProvider->addMethodsClassReflectionExtension($annotationsMethodsClassReflectionExtension);
        $setterReflectionProviderProvider->setReflectionProvider($actualReflectionProvider);
    }
    private function createStaticReflectionProvider() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider
    {
        $parser = $this->getParser();
        $phpDocStringResolver = self::getContainer()->getByType(\_PhpScoperb75b35f52b74\PHPStan\PhpDoc\PhpDocStringResolver::class);
        $phpDocNodeResolver = self::getContainer()->getByType(\_PhpScoperb75b35f52b74\PHPStan\PhpDoc\PhpDocNodeResolver::class);
        $currentWorkingDirectory = $this->getCurrentWorkingDirectory();
        $cache = new \_PhpScoperb75b35f52b74\PHPStan\Cache\Cache(new \_PhpScoperb75b35f52b74\PHPStan\Cache\MemoryCacheStorage());
        $fileHelper = new \_PhpScoperb75b35f52b74\PHPStan\File\FileHelper($currentWorkingDirectory);
        $relativePathHelper = new \_PhpScoperb75b35f52b74\PHPStan\File\SimpleRelativePathHelper($currentWorkingDirectory);
        $anonymousClassNameHelper = new \_PhpScoperb75b35f52b74\PHPStan\Broker\AnonymousClassNameHelper($fileHelper, new \_PhpScoperb75b35f52b74\PHPStan\File\SimpleRelativePathHelper($fileHelper->normalizePath($currentWorkingDirectory, '/')));
        $setterReflectionProviderProvider = new \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider();
        $fileTypeMapper = new \_PhpScoperb75b35f52b74\PHPStan\Type\FileTypeMapper($setterReflectionProviderProvider, $parser, $phpDocStringResolver, $phpDocNodeResolver, $cache, $anonymousClassNameHelper);
        $functionCallStatementFinder = new \_PhpScoperb75b35f52b74\PHPStan\Parser\FunctionCallStatementFinder();
        $functionReflectionFactory = $this->getFunctionReflectionFactory($functionCallStatementFinder, $cache);
        [$classReflector, $functionReflector, $constantReflector] = self::getReflectors();
        $classReflectionExtensionRegistryProvider = $this->getClassReflectionExtensionRegistryProvider();
        $reflectionProvider = new \_PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\BetterReflectionProvider($setterReflectionProviderProvider, $classReflectionExtensionRegistryProvider, $classReflector, $fileTypeMapper, self::getContainer()->getByType(\_PhpScoperb75b35f52b74\PHPStan\Php\PhpVersion::class), self::getContainer()->getByType(\_PhpScoperb75b35f52b74\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider::class), self::getContainer()->getByType(\_PhpScoperb75b35f52b74\PHPStan\PhpDoc\StubPhpDocProvider::class), $functionReflectionFactory, $relativePathHelper, $anonymousClassNameHelper, self::getContainer()->getByType(\_PhpScoperb75b35f52b74\PhpParser\PrettyPrinter\Standard::class), $fileHelper, $functionReflector, $constantReflector);
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
        if (!\class_exists(\_PhpScoperb75b35f52b74\Composer\Autoload\ClassLoader::class)) {
            self::fail('Composer ClassLoader is unknown');
        }
        $classLoaderReflection = new \ReflectionClass(\_PhpScoperb75b35f52b74\Composer\Autoload\ClassLoader::class);
        if ($classLoaderReflection->getFileName() === \false) {
            self::fail('Unknown ClassLoader filename');
        }
        $composerProjectPath = \dirname($classLoaderReflection->getFileName(), 3);
        if (!\is_file($composerProjectPath . '/composer.json')) {
            self::fail(\sprintf('composer.json not found in directory %s', $composerProjectPath));
        }
        $composerJsonAndInstalledJsonSourceLocatorMaker = self::getContainer()->getByType(\_PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\SourceLocator\ComposerJsonAndInstalledJsonSourceLocatorMaker::class);
        $composerSourceLocator = $composerJsonAndInstalledJsonSourceLocatorMaker->create($composerProjectPath);
        if ($composerSourceLocator === null) {
            self::fail('Could not create composer source locator');
        }
        // these need to be synced with TestCase-staticReflection.neon file and TestCaseSourceLocatorFactory
        $locators = [$composerSourceLocator];
        $phpParser = new \_PhpScoperb75b35f52b74\PHPStan\Parser\PhpParserDecorator(self::getContainer()->getByType(\_PhpScoperb75b35f52b74\PHPStan\Parser\CachedParser::class));
        /** @var FunctionReflector $functionReflector */
        $functionReflector = null;
        $astLocator = new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator($phpParser, static function () use(&$functionReflector) : FunctionReflector {
            return $functionReflector;
        });
        $reflectionSourceStubber = new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber();
        $locators[] = new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, self::getPhpStormStubsSourceStubber());
        $locators[] = new \_PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator(self::getContainer()->getByType(\_PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher::class));
        $locators[] = new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, $reflectionSourceStubber);
        $locators[] = new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator($astLocator, $reflectionSourceStubber);
        $sourceLocator = new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator(new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator($locators));
        $classReflector = new \_PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\Reflector\MemoizingClassReflector($sourceLocator);
        $functionReflector = new \_PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\Reflector\MemoizingFunctionReflector($sourceLocator, $classReflector);
        $constantReflector = new \_PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\Reflector\MemoizingConstantReflector($sourceLocator, $classReflector);
        self::$reflectors = [$classReflector, $functionReflector, $constantReflector];
        return self::$reflectors;
    }
    private function getFunctionReflectionFactory(\_PhpScoperb75b35f52b74\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \_PhpScoperb75b35f52b74\PHPStan\Cache\Cache $cache) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflectionFactory
    {
        return new class($this->getParser(), $functionCallStatementFinder, $cache) implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflectionFactory
        {
            /** @var \PHPStan\Parser\Parser */
            private $parser;
            /** @var \PHPStan\Parser\FunctionCallStatementFinder */
            private $functionCallStatementFinder;
            /** @var \PHPStan\Cache\Cache */
            private $cache;
            public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Parser\Parser $parser, \_PhpScoperb75b35f52b74\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \_PhpScoperb75b35f52b74\PHPStan\Cache\Cache $cache)
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
            public function create(\ReflectionFunction $function, \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $phpDocReturnType, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, $filename) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpFunctionReflection
            {
                return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpFunctionReflection($function, $this->parser, $this->functionCallStatementFinder, $this->cache, $templateTypeMap, $phpDocParameterTypes, $phpDocReturnType, $phpDocThrowType, $deprecatedDescription, $isDeprecated, $isInternal, $isFinal, $filename);
            }
        };
    }
    public function getClassReflectionExtensionRegistryProvider() : \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider
    {
        if ($this->classReflectionExtensionRegistryProvider === null) {
            $this->classReflectionExtensionRegistryProvider = new \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider([], []);
        }
        return $this->classReflectionExtensionRegistryProvider;
    }
    public function createScopeFactory(\_PhpScoperb75b35f52b74\PHPStan\Broker\Broker $broker, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : \_PhpScoperb75b35f52b74\PHPStan\Analyser\ScopeFactory
    {
        $container = self::getContainer();
        return new \_PhpScoperb75b35f52b74\PHPStan\Analyser\DirectScopeFactory(\_PhpScoperb75b35f52b74\PHPStan\Analyser\MutatingScope::class, $broker, $broker->getDynamicReturnTypeExtensionRegistryProvider(), $broker->getOperatorTypeSpecifyingExtensionRegistryProvider(), new \_PhpScoperb75b35f52b74\PhpParser\PrettyPrinter\Standard(), $typeSpecifier, new \_PhpScoperb75b35f52b74\PHPStan\Rules\Properties\PropertyReflectionFinder(), $this->getParser(), $this->shouldTreatPhpDocTypesAsCertain(), $container);
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
    public function createTypeSpecifier(\_PhpScoperb75b35f52b74\PhpParser\PrettyPrinter\Standard $printer, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $reflectionProvider, array $methodTypeSpecifyingExtensions = [], array $staticMethodTypeSpecifyingExtensions = []) : \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifier
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifier($printer, $reflectionProvider, self::getContainer()->getServicesByTag(\_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierFactory::FUNCTION_TYPE_SPECIFYING_EXTENSION_TAG), $methodTypeSpecifyingExtensions, $staticMethodTypeSpecifyingExtensions);
    }
    public function getFileHelper() : \_PhpScoperb75b35f52b74\PHPStan\File\FileHelper
    {
        return self::getContainer()->getByType(\_PhpScoperb75b35f52b74\PHPStan\File\FileHelper::class);
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
