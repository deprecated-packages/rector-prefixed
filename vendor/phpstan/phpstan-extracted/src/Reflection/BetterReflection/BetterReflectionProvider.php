<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\BetterReflection;

use _PhpScopere8e811afab72\PhpParser\PrettyPrinter\Standard;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Broker\AnonymousClassNameHelper;
use _PhpScopere8e811afab72\PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider;
use _PhpScopere8e811afab72\PHPStan\File\FileHelper;
use _PhpScopere8e811afab72\PHPStan\File\RelativePathHelper;
use _PhpScopere8e811afab72\PHPStan\Php\PhpVersion;
use _PhpScopere8e811afab72\PHPStan\PhpDoc\StubPhpDocProvider;
use _PhpScopere8e811afab72\PHPStan\PhpDoc\Tag\ParamTag;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\Constant\RuntimeConstantReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflectionFactory;
use _PhpScopere8e811afab72\PHPStan\Reflection\GlobalConstantReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Type\ConstantTypeHelper;
use _PhpScopere8e811afab72\PHPStan\Type\FileTypeMapper;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Exception\InvalidIdentifierName;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\Exception\UnableToCompileNode;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionClass;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionFunction;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAClassReflection;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ConstantReflector;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
class BetterReflectionProvider implements \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider
{
    /** @var ReflectionProvider\ReflectionProviderProvider */
    private $reflectionProviderProvider;
    /** @var \PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider */
    private $classReflectionExtensionRegistryProvider;
    /** @var \Roave\BetterReflection\Reflector\ClassReflector */
    private $classReflector;
    /** @var \Roave\BetterReflection\Reflector\FunctionReflector */
    private $functionReflector;
    /** @var \Roave\BetterReflection\Reflector\ConstantReflector */
    private $constantReflector;
    /** @var \PHPStan\Type\FileTypeMapper */
    private $fileTypeMapper;
    /** @var PhpVersion */
    private $phpVersion;
    /** @var \PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider */
    private $nativeFunctionReflectionProvider;
    /** @var StubPhpDocProvider */
    private $stubPhpDocProvider;
    /** @var \PHPStan\Reflection\FunctionReflectionFactory */
    private $functionReflectionFactory;
    /** @var RelativePathHelper */
    private $relativePathHelper;
    /** @var AnonymousClassNameHelper */
    private $anonymousClassNameHelper;
    /** @var \PhpParser\PrettyPrinter\Standard */
    private $printer;
    /** @var \PHPStan\File\FileHelper */
    private $fileHelper;
    /** @var \PHPStan\Reflection\FunctionReflection[] */
    private $functionReflections = [];
    /** @var \PHPStan\Reflection\ClassReflection[] */
    private $classReflections = [];
    /** @var \PHPStan\Reflection\ClassReflection[] */
    private static $anonymousClasses = [];
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider $reflectionProviderProvider, \_PhpScopere8e811afab72\PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider $classReflectionExtensionRegistryProvider, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector $classReflector, \_PhpScopere8e811afab72\PHPStan\Type\FileTypeMapper $fileTypeMapper, \_PhpScopere8e811afab72\PHPStan\Php\PhpVersion $phpVersion, \_PhpScopere8e811afab72\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider $nativeFunctionReflectionProvider, \_PhpScopere8e811afab72\PHPStan\PhpDoc\StubPhpDocProvider $stubPhpDocProvider, \_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflectionFactory $functionReflectionFactory, \_PhpScopere8e811afab72\PHPStan\File\RelativePathHelper $relativePathHelper, \_PhpScopere8e811afab72\PHPStan\Broker\AnonymousClassNameHelper $anonymousClassNameHelper, \_PhpScopere8e811afab72\PhpParser\PrettyPrinter\Standard $printer, \_PhpScopere8e811afab72\PHPStan\File\FileHelper $fileHelper, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector $functionReflector, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ConstantReflector $constantReflector)
    {
        $this->reflectionProviderProvider = $reflectionProviderProvider;
        $this->classReflectionExtensionRegistryProvider = $classReflectionExtensionRegistryProvider;
        $this->classReflector = $classReflector;
        $this->fileTypeMapper = $fileTypeMapper;
        $this->phpVersion = $phpVersion;
        $this->nativeFunctionReflectionProvider = $nativeFunctionReflectionProvider;
        $this->stubPhpDocProvider = $stubPhpDocProvider;
        $this->functionReflectionFactory = $functionReflectionFactory;
        $this->relativePathHelper = $relativePathHelper;
        $this->anonymousClassNameHelper = $anonymousClassNameHelper;
        $this->printer = $printer;
        $this->fileHelper = $fileHelper;
        $this->functionReflector = $functionReflector;
        $this->constantReflector = $constantReflector;
    }
    public function hasClass(string $className) : bool
    {
        if (isset(self::$anonymousClasses[$className])) {
            return \true;
        }
        try {
            $this->classReflector->reflect($className);
            return \true;
        } catch (\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
            return \false;
        } catch (\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Exception\InvalidIdentifierName $e) {
            return \false;
        }
    }
    public function getClass(string $className) : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
    {
        if (isset(self::$anonymousClasses[$className])) {
            return self::$anonymousClasses[$className];
        }
        try {
            $reflectionClass = $this->classReflector->reflect($className);
        } catch (\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
            throw new \_PhpScopere8e811afab72\PHPStan\Broker\ClassNotFoundException($className);
        }
        $reflectionClassName = \strtolower($reflectionClass->getName());
        if (\array_key_exists($reflectionClassName, $this->classReflections)) {
            return $this->classReflections[$reflectionClassName];
        }
        $classReflection = new \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection($this->reflectionProviderProvider->getReflectionProvider(), $this->fileTypeMapper, $this->phpVersion, $this->classReflectionExtensionRegistryProvider->getRegistry()->getPropertiesClassReflectionExtensions(), $this->classReflectionExtensionRegistryProvider->getRegistry()->getMethodsClassReflectionExtensions(), $reflectionClass->getName(), new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionClass($reflectionClass), null, null, $this->stubPhpDocProvider->findClassPhpDoc($className));
        $this->classReflections[$reflectionClassName] = $classReflection;
        return $classReflection;
    }
    public function getClassName(string $className) : string
    {
        if (!$this->hasClass($className)) {
            throw new \_PhpScopere8e811afab72\PHPStan\Broker\ClassNotFoundException($className);
        }
        if (isset(self::$anonymousClasses[$className])) {
            return self::$anonymousClasses[$className]->getDisplayName();
        }
        $reflectionClass = $this->classReflector->reflect($className);
        return $reflectionClass->getName();
    }
    public function supportsAnonymousClasses() : bool
    {
        return \true;
    }
    public function getAnonymousClassReflection(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $classNode, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
    {
        if (isset($classNode->namespacedName)) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        if (!$scope->isInTrait()) {
            $scopeFile = $scope->getFile();
        } else {
            $scopeFile = $scope->getTraitReflection()->getFileName();
            if ($scopeFile === \false) {
                $scopeFile = $scope->getFile();
            }
        }
        $filename = $this->fileHelper->normalizePath($this->relativePathHelper->getRelativePath($scopeFile), '/');
        $className = $this->anonymousClassNameHelper->getAnonymousClassName($classNode, $scopeFile);
        $classNode->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($className);
        $classNode->setAttribute('anonymousClass', \true);
        if (isset(self::$anonymousClasses[$className])) {
            return self::$anonymousClasses[$className];
        }
        $reflectionClass = \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass::createFromNode($this->classReflector, $classNode, new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource($this->printer->prettyPrint([$classNode]), $scopeFile), null);
        self::$anonymousClasses[$className] = new \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection($this->reflectionProviderProvider->getReflectionProvider(), $this->fileTypeMapper, $this->phpVersion, $this->classReflectionExtensionRegistryProvider->getRegistry()->getPropertiesClassReflectionExtensions(), $this->classReflectionExtensionRegistryProvider->getRegistry()->getMethodsClassReflectionExtensions(), \sprintf('class@anonymous/%s:%s', $filename, $classNode->getLine()), new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionClass($reflectionClass), $scopeFile, null, $this->stubPhpDocProvider->findClassPhpDoc($className));
        $this->classReflections[$className] = self::$anonymousClasses[$className];
        return self::$anonymousClasses[$className];
    }
    public function hasFunction(\_PhpScopere8e811afab72\PhpParser\Node\Name $nameNode, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->resolveFunctionName($nameNode, $scope) !== null;
    }
    public function getFunction(\_PhpScopere8e811afab72\PhpParser\Node\Name $nameNode, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection
    {
        $functionName = $this->resolveFunctionName($nameNode, $scope);
        if ($functionName === null) {
            throw new \_PhpScopere8e811afab72\PHPStan\Broker\FunctionNotFoundException((string) $nameNode);
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
        $this->functionReflections[$lowerCasedFunctionName] = $this->getCustomFunction($functionName);
        return $this->functionReflections[$lowerCasedFunctionName];
    }
    private function getCustomFunction(string $functionName) : \_PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpFunctionReflection
    {
        $reflectionFunction = new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionFunction($this->functionReflector->reflect($functionName));
        $templateTypeMap = \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
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
        return $this->functionReflectionFactory->create($reflectionFunction, $templateTypeMap, \array_map(static function (\_PhpScopere8e811afab72\PHPStan\PhpDoc\Tag\ParamTag $paramTag) : Type {
            return $paramTag->getType();
        }, $phpDocParameterTags), $phpDocReturnTag !== null ? $phpDocReturnTag->getType() : null, $phpDocThrowsTag !== null ? $phpDocThrowsTag->getType() : null, $deprecatedTag !== null ? $deprecatedTag->getMessage() : null, $isDeprecated, $isInternal, $isFinal, $reflectionFunction->getFileName());
    }
    public function resolveFunctionName(\_PhpScopere8e811afab72\PhpParser\Node\Name $nameNode, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->resolveName($nameNode, function (string $name) : bool {
            try {
                $this->functionReflector->reflect($name);
                return \true;
            } catch (\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                // pass
            } catch (\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Exception\InvalidIdentifierName $e) {
                // pass
            }
            return \false;
        }, $scope);
    }
    public function hasConstant(\_PhpScopere8e811afab72\PhpParser\Node\Name $nameNode, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->resolveConstantName($nameNode, $scope) !== null;
    }
    public function getConstant(\_PhpScopere8e811afab72\PhpParser\Node\Name $nameNode, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\GlobalConstantReflection
    {
        $constantName = $this->resolveConstantName($nameNode, $scope);
        if ($constantName === null) {
            throw new \_PhpScopere8e811afab72\PHPStan\Broker\ConstantNotFoundException((string) $nameNode);
        }
        $constantReflection = $this->constantReflector->reflect($constantName);
        try {
            $constantValue = $constantReflection->getValue();
            $constantValueType = \_PhpScopere8e811afab72\PHPStan\Type\ConstantTypeHelper::getTypeFromValue($constantValue);
            $fileName = $constantReflection->getFileName();
        } catch (\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\Exception\UnableToCompileNode|\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAClassReflection|\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection $e) {
            $constantValueType = new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
            $fileName = null;
        }
        return new \_PhpScopere8e811afab72\PHPStan\Reflection\Constant\RuntimeConstantReflection($constantName, $constantValueType, $fileName);
    }
    public function resolveConstantName(\_PhpScopere8e811afab72\PhpParser\Node\Name $nameNode, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->resolveName($nameNode, function (string $name) : bool {
            try {
                $this->constantReflector->reflect($name);
                return \true;
            } catch (\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                // pass
            } catch (\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\Exception\UnableToCompileNode|\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAClassReflection|\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection $e) {
                // pass
            }
            return \false;
        }, $scope);
    }
    /**
     * @param \PhpParser\Node\Name $nameNode
     * @param \Closure(string $name): bool $existsCallback
     * @param Scope|null $scope
     * @return string|null
     */
    private function resolveName(\_PhpScopere8e811afab72\PhpParser\Node\Name $nameNode, \Closure $existsCallback, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : ?string
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
}
