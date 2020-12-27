<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\BetterReflection;

use PhpParser\PrettyPrinter\Standard;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Broker\AnonymousClassNameHelper;
use RectorPrefix20201227\PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider;
use RectorPrefix20201227\PHPStan\File\FileHelper;
use RectorPrefix20201227\PHPStan\File\RelativePathHelper;
use RectorPrefix20201227\PHPStan\Php\PhpVersion;
use RectorPrefix20201227\PHPStan\PhpDoc\StubPhpDocProvider;
use RectorPrefix20201227\PHPStan\PhpDoc\Tag\ParamTag;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\Constant\RuntimeConstantReflection;
use RectorPrefix20201227\PHPStan\Reflection\FunctionReflection;
use RectorPrefix20201227\PHPStan\Reflection\FunctionReflectionFactory;
use RectorPrefix20201227\PHPStan\Reflection\GlobalConstantReflection;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use RectorPrefix20201227\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider;
use PHPStan\Type\ConstantTypeHelper;
use PHPStan\Type\FileTypeMapper;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Exception\InvalidIdentifierName;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\Exception\UnableToCompileNode;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionClass;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionFunction;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAClassReflection;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ConstantReflector;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
class BetterReflectionProvider implements \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider
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
    public function __construct(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider $reflectionProviderProvider, \RectorPrefix20201227\PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider $classReflectionExtensionRegistryProvider, \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector $classReflector, \PHPStan\Type\FileTypeMapper $fileTypeMapper, \RectorPrefix20201227\PHPStan\Php\PhpVersion $phpVersion, \RectorPrefix20201227\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider $nativeFunctionReflectionProvider, \RectorPrefix20201227\PHPStan\PhpDoc\StubPhpDocProvider $stubPhpDocProvider, \RectorPrefix20201227\PHPStan\Reflection\FunctionReflectionFactory $functionReflectionFactory, \RectorPrefix20201227\PHPStan\File\RelativePathHelper $relativePathHelper, \RectorPrefix20201227\PHPStan\Broker\AnonymousClassNameHelper $anonymousClassNameHelper, \PhpParser\PrettyPrinter\Standard $printer, \RectorPrefix20201227\PHPStan\File\FileHelper $fileHelper, \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector $functionReflector, \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ConstantReflector $constantReflector)
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
        } catch (\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
            return \false;
        } catch (\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Exception\InvalidIdentifierName $e) {
            return \false;
        }
    }
    public function getClass(string $className) : \RectorPrefix20201227\PHPStan\Reflection\ClassReflection
    {
        if (isset(self::$anonymousClasses[$className])) {
            return self::$anonymousClasses[$className];
        }
        try {
            $reflectionClass = $this->classReflector->reflect($className);
        } catch (\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
            throw new \RectorPrefix20201227\PHPStan\Broker\ClassNotFoundException($className);
        }
        $reflectionClassName = \strtolower($reflectionClass->getName());
        if (\array_key_exists($reflectionClassName, $this->classReflections)) {
            return $this->classReflections[$reflectionClassName];
        }
        $classReflection = new \RectorPrefix20201227\PHPStan\Reflection\ClassReflection($this->reflectionProviderProvider->getReflectionProvider(), $this->fileTypeMapper, $this->phpVersion, $this->classReflectionExtensionRegistryProvider->getRegistry()->getPropertiesClassReflectionExtensions(), $this->classReflectionExtensionRegistryProvider->getRegistry()->getMethodsClassReflectionExtensions(), $reflectionClass->getName(), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionClass($reflectionClass), null, null, $this->stubPhpDocProvider->findClassPhpDoc($className));
        $this->classReflections[$reflectionClassName] = $classReflection;
        return $classReflection;
    }
    public function getClassName(string $className) : string
    {
        if (!$this->hasClass($className)) {
            throw new \RectorPrefix20201227\PHPStan\Broker\ClassNotFoundException($className);
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
    public function getAnonymousClassReflection(\PhpParser\Node\Stmt\Class_ $classNode, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \RectorPrefix20201227\PHPStan\Reflection\ClassReflection
    {
        if (isset($classNode->namespacedName)) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
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
        $reflectionClass = \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass::createFromNode($this->classReflector, $classNode, new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource($this->printer->prettyPrint([$classNode]), $scopeFile), null);
        self::$anonymousClasses[$className] = new \RectorPrefix20201227\PHPStan\Reflection\ClassReflection($this->reflectionProviderProvider->getReflectionProvider(), $this->fileTypeMapper, $this->phpVersion, $this->classReflectionExtensionRegistryProvider->getRegistry()->getPropertiesClassReflectionExtensions(), $this->classReflectionExtensionRegistryProvider->getRegistry()->getMethodsClassReflectionExtensions(), \sprintf('class@anonymous/%s:%s', $filename, $classNode->getLine()), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionClass($reflectionClass), $scopeFile, null, $this->stubPhpDocProvider->findClassPhpDoc($className));
        $this->classReflections[$className] = self::$anonymousClasses[$className];
        return self::$anonymousClasses[$className];
    }
    public function hasFunction(\PhpParser\Node\Name $nameNode, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->resolveFunctionName($nameNode, $scope) !== null;
    }
    public function getFunction(\PhpParser\Node\Name $nameNode, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \RectorPrefix20201227\PHPStan\Reflection\FunctionReflection
    {
        $functionName = $this->resolveFunctionName($nameNode, $scope);
        if ($functionName === null) {
            throw new \RectorPrefix20201227\PHPStan\Broker\FunctionNotFoundException((string) $nameNode);
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
    private function getCustomFunction(string $functionName) : \RectorPrefix20201227\PHPStan\Reflection\Php\PhpFunctionReflection
    {
        $reflectionFunction = new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionFunction($this->functionReflector->reflect($functionName));
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
        return $this->functionReflectionFactory->create($reflectionFunction, $templateTypeMap, \array_map(static function (\RectorPrefix20201227\PHPStan\PhpDoc\Tag\ParamTag $paramTag) : Type {
            return $paramTag->getType();
        }, $phpDocParameterTags), $phpDocReturnTag !== null ? $phpDocReturnTag->getType() : null, $phpDocThrowsTag !== null ? $phpDocThrowsTag->getType() : null, $deprecatedTag !== null ? $deprecatedTag->getMessage() : null, $isDeprecated, $isInternal, $isFinal, $reflectionFunction->getFileName());
    }
    public function resolveFunctionName(\PhpParser\Node\Name $nameNode, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->resolveName($nameNode, function (string $name) : bool {
            try {
                $this->functionReflector->reflect($name);
                return \true;
            } catch (\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                // pass
            } catch (\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Exception\InvalidIdentifierName $e) {
                // pass
            }
            return \false;
        }, $scope);
    }
    public function hasConstant(\PhpParser\Node\Name $nameNode, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->resolveConstantName($nameNode, $scope) !== null;
    }
    public function getConstant(\PhpParser\Node\Name $nameNode, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \RectorPrefix20201227\PHPStan\Reflection\GlobalConstantReflection
    {
        $constantName = $this->resolveConstantName($nameNode, $scope);
        if ($constantName === null) {
            throw new \RectorPrefix20201227\PHPStan\Broker\ConstantNotFoundException((string) $nameNode);
        }
        $constantReflection = $this->constantReflector->reflect($constantName);
        try {
            $constantValue = $constantReflection->getValue();
            $constantValueType = \PHPStan\Type\ConstantTypeHelper::getTypeFromValue($constantValue);
            $fileName = $constantReflection->getFileName();
        } catch (\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\Exception\UnableToCompileNode|\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAClassReflection|\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection $e) {
            $constantValueType = new \PHPStan\Type\MixedType();
            $fileName = null;
        }
        return new \RectorPrefix20201227\PHPStan\Reflection\Constant\RuntimeConstantReflection($constantName, $constantValueType, $fileName);
    }
    public function resolveConstantName(\PhpParser\Node\Name $nameNode, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->resolveName($nameNode, function (string $name) : bool {
            try {
                $this->constantReflector->reflect($name);
                return \true;
            } catch (\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                // pass
            } catch (\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\Exception\UnableToCompileNode|\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAClassReflection|\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection $e) {
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
    private function resolveName(\PhpParser\Node\Name $nameNode, \Closure $existsCallback, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : ?string
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
