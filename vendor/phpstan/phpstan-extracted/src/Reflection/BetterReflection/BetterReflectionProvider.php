<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection;

use PhpParser\PrettyPrinter\Standard;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\AnonymousClassNameHelper;
use PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider;
use PHPStan\File\FileHelper;
use PHPStan\File\RelativePathHelper;
use PHPStan\Php\PhpVersion;
use PHPStan\PhpDoc\StubPhpDocProvider;
use PHPStan\PhpDoc\Tag\ParamTag;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\Constant\RuntimeConstantReflection;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\FunctionReflectionFactory;
use PHPStan\Reflection\GlobalConstantReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider;
use PHPStan\Type\ConstantTypeHelper;
use PHPStan\Type\FileTypeMapper;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Exception\InvalidIdentifierName;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\Exception\UnableToCompileNode;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionClass;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionFunction;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAClassReflection;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ConstantReflector;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
class BetterReflectionProvider implements \PHPStan\Reflection\ReflectionProvider
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
    public function __construct(\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider $reflectionProviderProvider, \PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider $classReflectionExtensionRegistryProvider, \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector $classReflector, \PHPStan\Type\FileTypeMapper $fileTypeMapper, \PHPStan\Php\PhpVersion $phpVersion, \PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider $nativeFunctionReflectionProvider, \PHPStan\PhpDoc\StubPhpDocProvider $stubPhpDocProvider, \PHPStan\Reflection\FunctionReflectionFactory $functionReflectionFactory, \PHPStan\File\RelativePathHelper $relativePathHelper, \PHPStan\Broker\AnonymousClassNameHelper $anonymousClassNameHelper, \PhpParser\PrettyPrinter\Standard $printer, \PHPStan\File\FileHelper $fileHelper, \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector $functionReflector, \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ConstantReflector $constantReflector)
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
        } catch (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
            return \false;
        } catch (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Exception\InvalidIdentifierName $e) {
            return \false;
        }
    }
    public function getClass(string $className) : \PHPStan\Reflection\ClassReflection
    {
        if (isset(self::$anonymousClasses[$className])) {
            return self::$anonymousClasses[$className];
        }
        try {
            $reflectionClass = $this->classReflector->reflect($className);
        } catch (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
            throw new \PHPStan\Broker\ClassNotFoundException($className);
        }
        $reflectionClassName = \strtolower($reflectionClass->getName());
        if (\array_key_exists($reflectionClassName, $this->classReflections)) {
            return $this->classReflections[$reflectionClassName];
        }
        $classReflection = new \PHPStan\Reflection\ClassReflection($this->reflectionProviderProvider->getReflectionProvider(), $this->fileTypeMapper, $this->phpVersion, $this->classReflectionExtensionRegistryProvider->getRegistry()->getPropertiesClassReflectionExtensions(), $this->classReflectionExtensionRegistryProvider->getRegistry()->getMethodsClassReflectionExtensions(), $reflectionClass->getName(), new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionClass($reflectionClass), null, null, $this->stubPhpDocProvider->findClassPhpDoc($className));
        $this->classReflections[$reflectionClassName] = $classReflection;
        return $classReflection;
    }
    public function getClassName(string $className) : string
    {
        if (!$this->hasClass($className)) {
            throw new \PHPStan\Broker\ClassNotFoundException($className);
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
    public function getAnonymousClassReflection(\PhpParser\Node\Stmt\Class_ $classNode, \PHPStan\Analyser\Scope $scope) : \PHPStan\Reflection\ClassReflection
    {
        if (isset($classNode->namespacedName)) {
            throw new \PHPStan\ShouldNotHappenException();
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
        $classNode->name = new \PhpParser\Node\Identifier($className);
        $classNode->setAttribute('anonymousClass', \true);
        if (isset(self::$anonymousClasses[$className])) {
            return self::$anonymousClasses[$className];
        }
        $reflectionClass = \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass::createFromNode($this->classReflector, $classNode, new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource($this->printer->prettyPrint([$classNode]), $scopeFile), null);
        self::$anonymousClasses[$className] = new \PHPStan\Reflection\ClassReflection($this->reflectionProviderProvider->getReflectionProvider(), $this->fileTypeMapper, $this->phpVersion, $this->classReflectionExtensionRegistryProvider->getRegistry()->getPropertiesClassReflectionExtensions(), $this->classReflectionExtensionRegistryProvider->getRegistry()->getMethodsClassReflectionExtensions(), \sprintf('class@anonymous/%s:%s', $filename, $classNode->getLine()), new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionClass($reflectionClass), $scopeFile, null, $this->stubPhpDocProvider->findClassPhpDoc($className));
        $this->classReflections[$className] = self::$anonymousClasses[$className];
        return self::$anonymousClasses[$className];
    }
    public function hasFunction(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->resolveFunctionName($nameNode, $scope) !== null;
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
        $this->functionReflections[$lowerCasedFunctionName] = $this->getCustomFunction($functionName);
        return $this->functionReflections[$lowerCasedFunctionName];
    }
    private function getCustomFunction(string $functionName) : \PHPStan\Reflection\Php\PhpFunctionReflection
    {
        $reflectionFunction = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionFunction($this->functionReflector->reflect($functionName));
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
        return $this->functionReflectionFactory->create($reflectionFunction, $templateTypeMap, \array_map(static function (\PHPStan\PhpDoc\Tag\ParamTag $paramTag) : Type {
            return $paramTag->getType();
        }, $phpDocParameterTags), $phpDocReturnTag !== null ? $phpDocReturnTag->getType() : null, $phpDocThrowsTag !== null ? $phpDocThrowsTag->getType() : null, $deprecatedTag !== null ? $deprecatedTag->getMessage() : null, $isDeprecated, $isInternal, $isFinal, $reflectionFunction->getFileName());
    }
    public function resolveFunctionName(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->resolveName($nameNode, function (string $name) : bool {
            try {
                $this->functionReflector->reflect($name);
                return \true;
            } catch (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                // pass
            } catch (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Exception\InvalidIdentifierName $e) {
                // pass
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
        $constantReflection = $this->constantReflector->reflect($constantName);
        try {
            $constantValue = $constantReflection->getValue();
            $constantValueType = \PHPStan\Type\ConstantTypeHelper::getTypeFromValue($constantValue);
            $fileName = $constantReflection->getFileName();
        } catch (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\Exception\UnableToCompileNode|\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAClassReflection|\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection $e) {
            $constantValueType = new \PHPStan\Type\MixedType();
            $fileName = null;
        }
        return new \PHPStan\Reflection\Constant\RuntimeConstantReflection($constantName, $constantValueType, $fileName);
    }
    public function resolveConstantName(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->resolveName($nameNode, function (string $name) : bool {
            try {
                $this->constantReflector->reflect($name);
                return \true;
            } catch (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                // pass
            } catch (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\Exception\UnableToCompileNode|\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAClassReflection|\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection $e) {
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
}
