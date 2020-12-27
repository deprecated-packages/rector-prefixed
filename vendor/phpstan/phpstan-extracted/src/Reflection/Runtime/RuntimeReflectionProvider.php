<?php

declare (strict_types=1);
namespace PHPStan\Reflection\Runtime;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider;
use PHPStan\Php\PhpVersion;
use PHPStan\PhpDoc\StubPhpDocProvider;
use PHPStan\PhpDoc\Tag\ParamTag;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\Constant\RuntimeConstantReflection;
use PHPStan\Reflection\FunctionReflectionFactory;
use PHPStan\Reflection\GlobalConstantReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider;
use PHPStan\Type\ConstantTypeHelper;
use PHPStan\Type\FileTypeMapper;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Type;
use ReflectionClass;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
class RuntimeReflectionProvider implements \PHPStan\Reflection\ReflectionProvider
{
    /** @var ReflectionProvider\ReflectionProviderProvider */
    private $reflectionProviderProvider;
    /** @var ClassReflectionExtensionRegistryProvider */
    private $classReflectionExtensionRegistryProvider;
    /** @var \PHPStan\Reflection\ClassReflection[] */
    private $classReflections = [];
    /** @var \PHPStan\Reflection\FunctionReflectionFactory */
    private $functionReflectionFactory;
    /** @var \PHPStan\Type\FileTypeMapper */
    private $fileTypeMapper;
    /** @var PhpVersion */
    private $phpVersion;
    /** @var \PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider */
    private $nativeFunctionReflectionProvider;
    /** @var StubPhpDocProvider */
    private $stubPhpDocProvider;
    /** @var PhpStormStubsSourceStubber */
    private $phpStormStubsSourceStubber;
    /** @var \PHPStan\Reflection\FunctionReflection[] */
    private $functionReflections = [];
    /** @var \PHPStan\Reflection\Php\PhpFunctionReflection[] */
    private $customFunctionReflections = [];
    /** @var bool[] */
    private $hasClassCache = [];
    /** @var \PHPStan\Reflection\ClassReflection[] */
    private static $anonymousClasses = [];
    public function __construct(\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider $reflectionProviderProvider, \PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider $classReflectionExtensionRegistryProvider, \PHPStan\Reflection\FunctionReflectionFactory $functionReflectionFactory, \PHPStan\Type\FileTypeMapper $fileTypeMapper, \PHPStan\Php\PhpVersion $phpVersion, \PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider $nativeFunctionReflectionProvider, \PHPStan\PhpDoc\StubPhpDocProvider $stubPhpDocProvider, \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber $phpStormStubsSourceStubber)
    {
        $this->reflectionProviderProvider = $reflectionProviderProvider;
        $this->classReflectionExtensionRegistryProvider = $classReflectionExtensionRegistryProvider;
        $this->functionReflectionFactory = $functionReflectionFactory;
        $this->fileTypeMapper = $fileTypeMapper;
        $this->phpVersion = $phpVersion;
        $this->nativeFunctionReflectionProvider = $nativeFunctionReflectionProvider;
        $this->stubPhpDocProvider = $stubPhpDocProvider;
        $this->phpStormStubsSourceStubber = $phpStormStubsSourceStubber;
    }
    public function getClass(string $className) : \PHPStan\Reflection\ClassReflection
    {
        /** @var class-string $className */
        $className = $className;
        if (!$this->hasClass($className)) {
            throw new \PHPStan\Broker\ClassNotFoundException($className);
        }
        if (isset(self::$anonymousClasses[$className])) {
            return self::$anonymousClasses[$className];
        }
        if (!isset($this->classReflections[$className])) {
            $reflectionClass = new \ReflectionClass($className);
            $filename = null;
            if ($reflectionClass->getFileName() !== \false) {
                $filename = $reflectionClass->getFileName();
            }
            $classReflection = $this->getClassFromReflection($reflectionClass, $reflectionClass->getName(), $reflectionClass->isAnonymous() ? $filename : null);
            $this->classReflections[$className] = $classReflection;
            if ($className !== $reflectionClass->getName()) {
                // class alias optimization
                $this->classReflections[$reflectionClass->getName()] = $classReflection;
            }
        }
        return $this->classReflections[$className];
    }
    public function getClassName(string $className) : string
    {
        if (!$this->hasClass($className)) {
            throw new \PHPStan\Broker\ClassNotFoundException($className);
        }
        /** @var class-string $className */
        $className = $className;
        $reflectionClass = new \ReflectionClass($className);
        $realName = $reflectionClass->getName();
        if (isset(self::$anonymousClasses[$realName])) {
            return self::$anonymousClasses[$realName]->getDisplayName();
        }
        return $realName;
    }
    public function supportsAnonymousClasses() : bool
    {
        return \false;
    }
    public function getAnonymousClassReflection(\PhpParser\Node\Stmt\Class_ $classNode, \PHPStan\Analyser\Scope $scope) : \PHPStan\Reflection\ClassReflection
    {
        throw new \PHPStan\ShouldNotHappenException();
    }
    /**
     * @param \ReflectionClass<object> $reflectionClass
     * @param string $displayName
     * @param string|null $anonymousFilename
     */
    private function getClassFromReflection(\ReflectionClass $reflectionClass, string $displayName, ?string $anonymousFilename) : \PHPStan\Reflection\ClassReflection
    {
        $className = $reflectionClass->getName();
        if (!isset($this->classReflections[$className])) {
            $classReflection = new \PHPStan\Reflection\ClassReflection($this->reflectionProviderProvider->getReflectionProvider(), $this->fileTypeMapper, $this->phpVersion, $this->classReflectionExtensionRegistryProvider->getRegistry()->getPropertiesClassReflectionExtensions(), $this->classReflectionExtensionRegistryProvider->getRegistry()->getMethodsClassReflectionExtensions(), $displayName, $reflectionClass, $anonymousFilename, null, $this->stubPhpDocProvider->findClassPhpDoc($className));
            $this->classReflections[$className] = $classReflection;
        }
        return $this->classReflections[$className];
    }
    public function hasClass(string $className) : bool
    {
        $className = \trim($className, '\\');
        if (isset($this->hasClassCache[$className])) {
            return $this->hasClassCache[$className];
        }
        \spl_autoload_register($autoloader = function (string $autoloadedClassName) use($className) : void {
            $autoloadedClassName = \trim($autoloadedClassName, '\\');
            if ($autoloadedClassName !== $className && !$this->isExistsCheckCall()) {
                throw new \PHPStan\Broker\ClassAutoloadingException($autoloadedClassName);
            }
        });
        try {
            return $this->hasClassCache[$className] = \class_exists($className) || \interface_exists($className) || \trait_exists($className);
        } catch (\PHPStan\Broker\ClassAutoloadingException $e) {
            throw $e;
        } catch (\Throwable $t) {
            throw new \PHPStan\Broker\ClassAutoloadingException($className, $t);
        } finally {
            \spl_autoload_unregister($autoloader);
        }
    }
    public function getFunction(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : \PHPStan\Reflection\FunctionReflection
    {
        $functionName = $this->resolveFunctionName($nameNode, $scope);
        if ($functionName === null) {
            throw new \PHPStan\Broker\FunctionNotFoundException((string) $nameNode);
        }
        $lowerCasedFunctionName = \strtolower($functionName);
        if (isset($this->functionReflections[$lowerCasedFunctionName])) {
            return $this->functionReflections[$lowerCasedFunctionName];
        }
        $nativeFunctionReflection = $this->nativeFunctionReflectionProvider->findFunctionReflection($lowerCasedFunctionName);
        if ($nativeFunctionReflection !== null) {
            $this->functionReflections[$lowerCasedFunctionName] = $nativeFunctionReflection;
            return $nativeFunctionReflection;
        }
        $this->functionReflections[$lowerCasedFunctionName] = $this->getCustomFunction($nameNode, $scope);
        return $this->functionReflections[$lowerCasedFunctionName];
    }
    public function hasFunction(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->resolveFunctionName($nameNode, $scope) !== null;
    }
    private function hasCustomFunction(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : bool
    {
        $functionName = $this->resolveFunctionName($nameNode, $scope);
        if ($functionName === null) {
            return \false;
        }
        return $this->nativeFunctionReflectionProvider->findFunctionReflection($functionName) === null;
    }
    private function getCustomFunction(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : \PHPStan\Reflection\Php\PhpFunctionReflection
    {
        if (!$this->hasCustomFunction($nameNode, $scope)) {
            throw new \PHPStan\Broker\FunctionNotFoundException((string) $nameNode);
        }
        /** @var string $functionName */
        $functionName = $this->resolveFunctionName($nameNode, $scope);
        if (!\function_exists($functionName)) {
            throw new \PHPStan\Broker\FunctionNotFoundException($functionName);
        }
        $lowerCasedFunctionName = \strtolower($functionName);
        if (isset($this->customFunctionReflections[$lowerCasedFunctionName])) {
            return $this->customFunctionReflections[$lowerCasedFunctionName];
        }
        $reflectionFunction = new \ReflectionFunction($functionName);
        $templateTypeMap = \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        $phpDocParameterTags = [];
        $phpDocReturnTag = null;
        $phpDocThrowsTag = null;
        $deprecatedTag = null;
        $isDeprecated = \false;
        $isInternal = \false;
        $isFinal = \false;
        $resolvedPhpDoc = $this->stubPhpDocProvider->findFunctionPhpDoc($reflectionFunction->getName());
        if ($resolvedPhpDoc === null && $reflectionFunction->getFileName() !== \false && $reflectionFunction->getDocComment() !== \false) {
            $fileName = $reflectionFunction->getFileName();
            $docComment = $reflectionFunction->getDocComment();
            $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($fileName, null, null, $reflectionFunction->getName(), $docComment);
        }
        if ($resolvedPhpDoc !== null) {
            $templateTypeMap = $resolvedPhpDoc->getTemplateTypeMap();
            $phpDocParameterTags = $resolvedPhpDoc->getParamTags();
            $phpDocReturnTag = $resolvedPhpDoc->getReturnTag();
            $phpDocThrowsTag = $resolvedPhpDoc->getThrowsTag();
            $deprecatedTag = $resolvedPhpDoc->getDeprecatedTag();
            $isDeprecated = $resolvedPhpDoc->isDeprecated();
            $isInternal = $resolvedPhpDoc->isInternal();
            $isFinal = $resolvedPhpDoc->isFinal();
        }
        $functionReflection = $this->functionReflectionFactory->create($reflectionFunction, $templateTypeMap, \array_map(static function (\PHPStan\PhpDoc\Tag\ParamTag $paramTag) : Type {
            return $paramTag->getType();
        }, $phpDocParameterTags), $phpDocReturnTag !== null ? $phpDocReturnTag->getType() : null, $phpDocThrowsTag !== null ? $phpDocThrowsTag->getType() : null, $deprecatedTag !== null ? $deprecatedTag->getMessage() : null, $isDeprecated, $isInternal, $isFinal, $reflectionFunction->getFileName());
        $this->customFunctionReflections[$lowerCasedFunctionName] = $functionReflection;
        return $functionReflection;
    }
    public function resolveFunctionName(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->resolveName($nameNode, function (string $name) : bool {
            $exists = \function_exists($name);
            if ($exists) {
                if ($this->phpStormStubsSourceStubber->isPresentFunction($name) === \false) {
                    return \false;
                }
                return \true;
            }
            return \false;
        }, $scope);
    }
    public function hasConstant(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->resolveConstantName($nameNode, $scope) !== null;
    }
    public function getConstant(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : \PHPStan\Reflection\GlobalConstantReflection
    {
        $constantName = $this->resolveConstantName($nameNode, $scope);
        if ($constantName === null) {
            throw new \PHPStan\Broker\ConstantNotFoundException((string) $nameNode);
        }
        return new \PHPStan\Reflection\Constant\RuntimeConstantReflection($constantName, \PHPStan\Type\ConstantTypeHelper::getTypeFromValue(\constant($constantName)), null);
    }
    public function resolveConstantName(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->resolveName($nameNode, static function (string $name) : bool {
            return \defined($name);
        }, $scope);
    }
    /**
     * @param Node\Name $nameNode
     * @param \Closure(string $name): bool $existsCallback
     * @param Scope|null $scope
     * @return string|null
     */
    private function resolveName(\PhpParser\Node\Name $nameNode, \Closure $existsCallback, ?\PHPStan\Analyser\Scope $scope) : ?string
    {
        $name = (string) $nameNode;
        if ($scope !== null && $scope->getNamespace() !== null && !$nameNode->isFullyQualified()) {
            $namespacedName = \sprintf('%s\\%s', $scope->getNamespace(), $name);
            if ($existsCallback($namespacedName)) {
                return $namespacedName;
            }
        }
        if ($existsCallback($name)) {
            return $name;
        }
        return null;
    }
    private function isExistsCheckCall() : bool
    {
        $debugBacktrace = \debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS);
        $existsCallTypes = ['class_exists' => \true, 'interface_exists' => \true, 'trait_exists' => \true];
        foreach ($debugBacktrace as $traceStep) {
            if (isset($traceStep['function']) && isset($existsCallTypes[$traceStep['function']]) && (!isset($traceStep['file']) || $traceStep['file'] !== __FILE__)) {
                return \true;
            }
        }
        return \false;
    }
}
