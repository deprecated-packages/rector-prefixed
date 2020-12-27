<?php

declare (strict_types=1);
namespace PHPStan\Testing;

use Composer\Autoload\ClassLoader;
use PhpParser\PrettyPrinter\Standard;
use PHPStan\Analyser\DirectScopeFactory;
use PHPStan\Analyser\MutatingScope;
use PHPStan\Analyser\NodeScopeResolver;
use PHPStan\Analyser\ScopeFactory;
use PHPStan\Analyser\TypeSpecifier;
use PHPStan\Analyser\TypeSpecifierFactory;
use PHPStan\Broker\AnonymousClassNameHelper;
use PHPStan\Broker\Broker;
use PHPStan\Broker\BrokerFactory;
use PHPStan\Cache\Cache;
use PHPStan\Cache\MemoryCacheStorage;
use PHPStan\DependencyInjection\Container;
use PHPStan\DependencyInjection\ContainerFactory;
use PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider;
use PHPStan\DependencyInjection\Type\DirectDynamicReturnTypeExtensionRegistryProvider;
use PHPStan\DependencyInjection\Type\DirectOperatorTypeSpecifyingExtensionRegistryProvider;
use PHPStan\File\FileHelper;
use PHPStan\File\SimpleRelativePathHelper;
use PHPStan\Parser\CachedParser;
use PHPStan\Parser\FunctionCallStatementFinder;
use PHPStan\Parser\Parser;
use PHPStan\Parser\PhpParserDecorator;
use PHPStan\Php\PhpVersion;
use PHPStan\PhpDoc\PhpDocInheritanceResolver;
use PHPStan\PhpDoc\PhpDocNodeResolver;
use PHPStan\PhpDoc\PhpDocStringResolver;
use PHPStan\PhpDoc\StubPhpDocProvider;
use PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension;
use PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension;
use PHPStan\Reflection\BetterReflection\BetterReflectionProvider;
use PHPStan\Reflection\BetterReflection\Reflector\MemoizingClassReflector;
use PHPStan\Reflection\BetterReflection\Reflector\MemoizingConstantReflector;
use PHPStan\Reflection\BetterReflection\Reflector\MemoizingFunctionReflector;
use PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator;
use PHPStan\Reflection\BetterReflection\SourceLocator\ComposerJsonAndInstalledJsonSourceLocatorMaker;
use PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionReflectionFactory;
use PHPStan\Reflection\Mixin\MixinMethodsClassReflectionExtension;
use PHPStan\Reflection\Mixin\MixinPropertiesClassReflectionExtension;
use PHPStan\Reflection\Php\PhpClassReflectionExtension;
use PHPStan\Reflection\Php\PhpFunctionReflection;
use PHPStan\Reflection\Php\PhpMethodReflection;
use PHPStan\Reflection\Php\PhpMethodReflectionFactory;
use PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Reflection\ReflectionProvider\ClassBlacklistReflectionProvider;
use PHPStan\Reflection\ReflectionProvider\ReflectionProviderFactory;
use PHPStan\Reflection\Runtime\RuntimeReflectionProvider;
use PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider;
use PHPStan\Reflection\SignatureMap\SignatureMapProvider;
use PHPStan\Rules\Properties\PropertyReflectionFinder;
use PHPStan\Type\FileTypeMapper;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Php\SimpleXMLElementClassPropertyReflectionExtension;
use PHPStan\Type\Type;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ConstantReflector;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator;
abstract class TestCase extends \PHPUnit\Framework\TestCase
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
    public static function getContainer() : \PHPStan\DependencyInjection\Container
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
            $containerFactory = new \PHPStan\DependencyInjection\ContainerFactory($rootDir);
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
    public function getParser() : \PHPStan\Parser\Parser
    {
        /** @var \PHPStan\Parser\Parser $parser */
        $parser = self::getContainer()->getByType(\PHPStan\Parser\CachedParser::class);
        return $parser;
    }
    /**
     * @param \PHPStan\Type\DynamicMethodReturnTypeExtension[] $dynamicMethodReturnTypeExtensions
     * @param \PHPStan\Type\DynamicStaticMethodReturnTypeExtension[] $dynamicStaticMethodReturnTypeExtensions
     * @return \PHPStan\Broker\Broker
     */
    public function createBroker(array $dynamicMethodReturnTypeExtensions = [], array $dynamicStaticMethodReturnTypeExtensions = []) : \PHPStan\Broker\Broker
    {
        $dynamicReturnTypeExtensionRegistryProvider = new \PHPStan\DependencyInjection\Type\DirectDynamicReturnTypeExtensionRegistryProvider(\array_merge(self::getContainer()->getServicesByTag(\PHPStan\Broker\BrokerFactory::DYNAMIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $dynamicMethodReturnTypeExtensions, $this->getDynamicMethodReturnTypeExtensions()), \array_merge(self::getContainer()->getServicesByTag(\PHPStan\Broker\BrokerFactory::DYNAMIC_STATIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $dynamicStaticMethodReturnTypeExtensions, $this->getDynamicStaticMethodReturnTypeExtensions()), \array_merge(self::getContainer()->getServicesByTag(\PHPStan\Broker\BrokerFactory::DYNAMIC_FUNCTION_RETURN_TYPE_EXTENSION_TAG), $this->getDynamicFunctionReturnTypeExtensions()));
        $operatorTypeSpecifyingExtensionRegistryProvider = new \PHPStan\DependencyInjection\Type\DirectOperatorTypeSpecifyingExtensionRegistryProvider($this->getOperatorTypeSpecifyingExtensions());
        $reflectionProvider = $this->createReflectionProvider();
        $broker = new \PHPStan\Broker\Broker($reflectionProvider, $dynamicReturnTypeExtensionRegistryProvider, $operatorTypeSpecifyingExtensionRegistryProvider, self::getContainer()->getParameter('universalObjectCratesClasses'));
        $dynamicReturnTypeExtensionRegistryProvider->setBroker($broker);
        $dynamicReturnTypeExtensionRegistryProvider->setReflectionProvider($reflectionProvider);
        $operatorTypeSpecifyingExtensionRegistryProvider->setBroker($broker);
        $this->getClassReflectionExtensionRegistryProvider()->setBroker($broker);
        return $broker;
    }
    public function createReflectionProvider() : \PHPStan\Reflection\ReflectionProvider
    {
        $staticReflectionProvider = $this->createStaticReflectionProvider();
        return $this->createReflectionProviderByParameters($this->createRuntimeReflectionProvider($staticReflectionProvider), $staticReflectionProvider, self::$useStaticReflectionProvider);
    }
    private function createReflectionProviderByParameters(\PHPStan\Reflection\ReflectionProvider $runtimeReflectionProvider, \PHPStan\Reflection\ReflectionProvider $staticReflectionProvider, bool $disableRuntimeReflectionProvider) : \PHPStan\Reflection\ReflectionProvider
    {
        $setterReflectionProviderProvider = new \PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider();
        $reflectionProviderFactory = new \PHPStan\Reflection\ReflectionProvider\ReflectionProviderFactory($runtimeReflectionProvider, $staticReflectionProvider, $disableRuntimeReflectionProvider);
        $reflectionProvider = $reflectionProviderFactory->create();
        $setterReflectionProviderProvider->setReflectionProvider($reflectionProvider);
        return $reflectionProvider;
    }
    private static function getPhpStormStubsSourceStubber() : \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber
    {
        if (self::$phpStormStubsSourceStubber === null) {
            self::$phpStormStubsSourceStubber = self::getContainer()->getByType(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber::class);
        }
        return self::$phpStormStubsSourceStubber;
    }
    private function createRuntimeReflectionProvider(\PHPStan\Reflection\ReflectionProvider $actualReflectionProvider) : \PHPStan\Reflection\ReflectionProvider
    {
        $functionCallStatementFinder = new \PHPStan\Parser\FunctionCallStatementFinder();
        $parser = $this->getParser();
        $cache = new \PHPStan\Cache\Cache(new \PHPStan\Cache\MemoryCacheStorage());
        $phpDocStringResolver = self::getContainer()->getByType(\PHPStan\PhpDoc\PhpDocStringResolver::class);
        $phpDocNodeResolver = self::getContainer()->getByType(\PHPStan\PhpDoc\PhpDocNodeResolver::class);
        $currentWorkingDirectory = $this->getCurrentWorkingDirectory();
        $fileHelper = new \PHPStan\File\FileHelper($currentWorkingDirectory);
        $anonymousClassNameHelper = new \PHPStan\Broker\AnonymousClassNameHelper(new \PHPStan\File\FileHelper($currentWorkingDirectory), new \PHPStan\File\SimpleRelativePathHelper($fileHelper->normalizePath($currentWorkingDirectory, '/')));
        $setterReflectionProviderProvider = new \PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider();
        $fileTypeMapper = new \PHPStan\Type\FileTypeMapper($setterReflectionProviderProvider, $parser, $phpDocStringResolver, $phpDocNodeResolver, $cache, $anonymousClassNameHelper);
        $classReflectionExtensionRegistryProvider = $this->getClassReflectionExtensionRegistryProvider();
        $functionReflectionFactory = $this->getFunctionReflectionFactory($functionCallStatementFinder, $cache);
        $reflectionProvider = new \PHPStan\Reflection\ReflectionProvider\ClassBlacklistReflectionProvider(new \PHPStan\Reflection\Runtime\RuntimeReflectionProvider($setterReflectionProviderProvider, $classReflectionExtensionRegistryProvider, $functionReflectionFactory, $fileTypeMapper, self::getContainer()->getByType(\PHPStan\Php\PhpVersion::class), self::getContainer()->getByType(\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider::class), self::getContainer()->getByType(\PHPStan\PhpDoc\StubPhpDocProvider::class), self::getContainer()->getByType(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber::class)), self::getPhpStormStubsSourceStubber(), ['#^PhpParser\\\\#', '#^PHPStan\\\\#', '#^Hoa\\\\#'], null);
        $this->setUpReflectionProvider($actualReflectionProvider, $setterReflectionProviderProvider, $classReflectionExtensionRegistryProvider, $functionCallStatementFinder, $parser, $cache, $fileTypeMapper);
        return $reflectionProvider;
    }
    private function setUpReflectionProvider(\PHPStan\Reflection\ReflectionProvider $actualReflectionProvider, \PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider $setterReflectionProviderProvider, \PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider $classReflectionExtensionRegistryProvider, \PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \PHPStan\Parser\Parser $parser, \PHPStan\Cache\Cache $cache, \PHPStan\Type\FileTypeMapper $fileTypeMapper) : void
    {
        $methodReflectionFactory = new class($parser, $functionCallStatementFinder, $cache) implements \PHPStan\Reflection\Php\PhpMethodReflectionFactory
        {
            /** @var \PHPStan\Parser\Parser */
            private $parser;
            /** @var \PHPStan\Parser\FunctionCallStatementFinder */
            private $functionCallStatementFinder;
            /** @var \PHPStan\Cache\Cache */
            private $cache;
            /** @var ReflectionProvider */
            public $reflectionProvider;
            public function __construct(\PHPStan\Parser\Parser $parser, \PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \PHPStan\Cache\Cache $cache)
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
            public function create(\PHPStan\Reflection\ClassReflection $declaringClass, ?\PHPStan\Reflection\ClassReflection $declaringTrait, \PHPStan\Reflection\Php\BuiltinMethodReflection $reflection, \PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\PHPStan\Type\Type $phpDocReturnType, ?\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, ?string $stubPhpDocString) : \PHPStan\Reflection\Php\PhpMethodReflection
            {
                return new \PHPStan\Reflection\Php\PhpMethodReflection($declaringClass, $declaringTrait, $reflection, $this->reflectionProvider, $this->parser, $this->functionCallStatementFinder, $this->cache, $templateTypeMap, $phpDocParameterTypes, $phpDocReturnType, $phpDocThrowType, $deprecatedDescription, $isDeprecated, $isInternal, $isFinal, $stubPhpDocString);
            }
        };
        $phpDocInheritanceResolver = new \PHPStan\PhpDoc\PhpDocInheritanceResolver($fileTypeMapper);
        $annotationsMethodsClassReflectionExtension = new \PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension();
        $annotationsPropertiesClassReflectionExtension = new \PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension();
        $signatureMapProvider = self::getContainer()->getByType(\PHPStan\Reflection\SignatureMap\SignatureMapProvider::class);
        $methodReflectionFactory->reflectionProvider = $actualReflectionProvider;
        $phpExtension = new \PHPStan\Reflection\Php\PhpClassReflectionExtension(self::getContainer()->getByType(\PHPStan\Analyser\ScopeFactory::class), self::getContainer()->getByType(\PHPStan\Analyser\NodeScopeResolver::class), $methodReflectionFactory, $phpDocInheritanceResolver, $annotationsMethodsClassReflectionExtension, $annotationsPropertiesClassReflectionExtension, $signatureMapProvider, $parser, self::getContainer()->getByType(\PHPStan\PhpDoc\StubPhpDocProvider::class), $actualReflectionProvider, $fileTypeMapper, \true, []);
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension($phpExtension);
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension(new \PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension([\stdClass::class]));
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension(new \PHPStan\Reflection\Mixin\MixinPropertiesClassReflectionExtension([]));
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension(new \PHPStan\Type\Php\SimpleXMLElementClassPropertyReflectionExtension());
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension($annotationsPropertiesClassReflectionExtension);
        $classReflectionExtensionRegistryProvider->addMethodsClassReflectionExtension($phpExtension);
        $classReflectionExtensionRegistryProvider->addMethodsClassReflectionExtension(new \PHPStan\Reflection\Mixin\MixinMethodsClassReflectionExtension([]));
        $classReflectionExtensionRegistryProvider->addMethodsClassReflectionExtension($annotationsMethodsClassReflectionExtension);
        $setterReflectionProviderProvider->setReflectionProvider($actualReflectionProvider);
    }
    private function createStaticReflectionProvider() : \PHPStan\Reflection\ReflectionProvider
    {
        $parser = $this->getParser();
        $phpDocStringResolver = self::getContainer()->getByType(\PHPStan\PhpDoc\PhpDocStringResolver::class);
        $phpDocNodeResolver = self::getContainer()->getByType(\PHPStan\PhpDoc\PhpDocNodeResolver::class);
        $currentWorkingDirectory = $this->getCurrentWorkingDirectory();
        $cache = new \PHPStan\Cache\Cache(new \PHPStan\Cache\MemoryCacheStorage());
        $fileHelper = new \PHPStan\File\FileHelper($currentWorkingDirectory);
        $relativePathHelper = new \PHPStan\File\SimpleRelativePathHelper($currentWorkingDirectory);
        $anonymousClassNameHelper = new \PHPStan\Broker\AnonymousClassNameHelper($fileHelper, new \PHPStan\File\SimpleRelativePathHelper($fileHelper->normalizePath($currentWorkingDirectory, '/')));
        $setterReflectionProviderProvider = new \PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider();
        $fileTypeMapper = new \PHPStan\Type\FileTypeMapper($setterReflectionProviderProvider, $parser, $phpDocStringResolver, $phpDocNodeResolver, $cache, $anonymousClassNameHelper);
        $functionCallStatementFinder = new \PHPStan\Parser\FunctionCallStatementFinder();
        $functionReflectionFactory = $this->getFunctionReflectionFactory($functionCallStatementFinder, $cache);
        [$classReflector, $functionReflector, $constantReflector] = self::getReflectors();
        $classReflectionExtensionRegistryProvider = $this->getClassReflectionExtensionRegistryProvider();
        $reflectionProvider = new \PHPStan\Reflection\BetterReflection\BetterReflectionProvider($setterReflectionProviderProvider, $classReflectionExtensionRegistryProvider, $classReflector, $fileTypeMapper, self::getContainer()->getByType(\PHPStan\Php\PhpVersion::class), self::getContainer()->getByType(\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider::class), self::getContainer()->getByType(\PHPStan\PhpDoc\StubPhpDocProvider::class), $functionReflectionFactory, $relativePathHelper, $anonymousClassNameHelper, self::getContainer()->getByType(\PhpParser\PrettyPrinter\Standard::class), $fileHelper, $functionReflector, $constantReflector);
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
        if (!\class_exists(\Composer\Autoload\ClassLoader::class)) {
            self::fail('Composer ClassLoader is unknown');
        }
        $classLoaderReflection = new \ReflectionClass(\Composer\Autoload\ClassLoader::class);
        if ($classLoaderReflection->getFileName() === \false) {
            self::fail('Unknown ClassLoader filename');
        }
        $composerProjectPath = \dirname($classLoaderReflection->getFileName(), 3);
        if (!\is_file($composerProjectPath . '/composer.json')) {
            self::fail(\sprintf('composer.json not found in directory %s', $composerProjectPath));
        }
        $composerJsonAndInstalledJsonSourceLocatorMaker = self::getContainer()->getByType(\PHPStan\Reflection\BetterReflection\SourceLocator\ComposerJsonAndInstalledJsonSourceLocatorMaker::class);
        $composerSourceLocator = $composerJsonAndInstalledJsonSourceLocatorMaker->create($composerProjectPath);
        if ($composerSourceLocator === null) {
            self::fail('Could not create composer source locator');
        }
        // these need to be synced with TestCase-staticReflection.neon file and TestCaseSourceLocatorFactory
        $locators = [$composerSourceLocator];
        $phpParser = new \PHPStan\Parser\PhpParserDecorator(self::getContainer()->getByType(\PHPStan\Parser\CachedParser::class));
        /** @var FunctionReflector $functionReflector */
        $functionReflector = null;
        $astLocator = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator($phpParser, static function () use(&$functionReflector) : FunctionReflector {
            return $functionReflector;
        });
        $reflectionSourceStubber = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber();
        $locators[] = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, self::getPhpStormStubsSourceStubber());
        $locators[] = new \PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator(self::getContainer()->getByType(\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher::class));
        $locators[] = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, $reflectionSourceStubber);
        $locators[] = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator($astLocator, $reflectionSourceStubber);
        $sourceLocator = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator(new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator($locators));
        $classReflector = new \PHPStan\Reflection\BetterReflection\Reflector\MemoizingClassReflector($sourceLocator);
        $functionReflector = new \PHPStan\Reflection\BetterReflection\Reflector\MemoizingFunctionReflector($sourceLocator, $classReflector);
        $constantReflector = new \PHPStan\Reflection\BetterReflection\Reflector\MemoizingConstantReflector($sourceLocator, $classReflector);
        self::$reflectors = [$classReflector, $functionReflector, $constantReflector];
        return self::$reflectors;
    }
    private function getFunctionReflectionFactory(\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \PHPStan\Cache\Cache $cache) : \PHPStan\Reflection\FunctionReflectionFactory
    {
        return new class($this->getParser(), $functionCallStatementFinder, $cache) implements \PHPStan\Reflection\FunctionReflectionFactory
        {
            /** @var \PHPStan\Parser\Parser */
            private $parser;
            /** @var \PHPStan\Parser\FunctionCallStatementFinder */
            private $functionCallStatementFinder;
            /** @var \PHPStan\Cache\Cache */
            private $cache;
            public function __construct(\PHPStan\Parser\Parser $parser, \PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \PHPStan\Cache\Cache $cache)
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
            public function create(\ReflectionFunction $function, \PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\PHPStan\Type\Type $phpDocReturnType, ?\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, $filename) : \PHPStan\Reflection\Php\PhpFunctionReflection
            {
                return new \PHPStan\Reflection\Php\PhpFunctionReflection($function, $this->parser, $this->functionCallStatementFinder, $this->cache, $templateTypeMap, $phpDocParameterTypes, $phpDocReturnType, $phpDocThrowType, $deprecatedDescription, $isDeprecated, $isInternal, $isFinal, $filename);
            }
        };
    }
    public function getClassReflectionExtensionRegistryProvider() : \PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider
    {
        if ($this->classReflectionExtensionRegistryProvider === null) {
            $this->classReflectionExtensionRegistryProvider = new \PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider([], []);
        }
        return $this->classReflectionExtensionRegistryProvider;
    }
    public function createScopeFactory(\PHPStan\Broker\Broker $broker, \PHPStan\Analyser\TypeSpecifier $typeSpecifier) : \PHPStan\Analyser\ScopeFactory
    {
        $container = self::getContainer();
        return new \PHPStan\Analyser\DirectScopeFactory(\PHPStan\Analyser\MutatingScope::class, $broker, $broker->getDynamicReturnTypeExtensionRegistryProvider(), $broker->getOperatorTypeSpecifyingExtensionRegistryProvider(), new \PhpParser\PrettyPrinter\Standard(), $typeSpecifier, new \PHPStan\Rules\Properties\PropertyReflectionFinder(), $this->getParser(), $this->shouldTreatPhpDocTypesAsCertain(), $container);
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
    public function createTypeSpecifier(\PhpParser\PrettyPrinter\Standard $printer, \PHPStan\Reflection\ReflectionProvider $reflectionProvider, array $methodTypeSpecifyingExtensions = [], array $staticMethodTypeSpecifyingExtensions = []) : \PHPStan\Analyser\TypeSpecifier
    {
        return new \PHPStan\Analyser\TypeSpecifier($printer, $reflectionProvider, self::getContainer()->getServicesByTag(\PHPStan\Analyser\TypeSpecifierFactory::FUNCTION_TYPE_SPECIFYING_EXTENSION_TAG), $methodTypeSpecifyingExtensions, $staticMethodTypeSpecifyingExtensions);
    }
    public function getFileHelper() : \PHPStan\File\FileHelper
    {
        return self::getContainer()->getByType(\PHPStan\File\FileHelper::class);
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
