<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\Php;

use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Declare_;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Namespace_;
use RectorPrefix20201227\PHPStan\Cache\Cache;
use RectorPrefix20201227\PHPStan\Parser\FunctionCallStatementFinder;
use RectorPrefix20201227\PHPStan\Parser\Parser;
use RectorPrefix20201227\PHPStan\Reflection\ClassMemberReflection;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\FunctionVariantWithPhpDocs;
use RectorPrefix20201227\PHPStan\Reflection\MethodPrototypeReflection;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptor;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorWithPhpDocs;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypehintHelper;
use PHPStan\Type\VoidType;
class PhpMethodReflection implements \RectorPrefix20201227\PHPStan\Reflection\MethodReflection
{
    /** @var \PHPStan\Reflection\ClassReflection */
    private $declaringClass;
    /** @var ClassReflection|null */
    private $declaringTrait;
    /** @var BuiltinMethodReflection */
    private $reflection;
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Parser\Parser */
    private $parser;
    /** @var \PHPStan\Parser\FunctionCallStatementFinder */
    private $functionCallStatementFinder;
    /** @var \PHPStan\Cache\Cache */
    private $cache;
    /** @var \PHPStan\Type\Generic\TemplateTypeMap */
    private $templateTypeMap;
    /** @var \PHPStan\Type\Type[] */
    private $phpDocParameterTypes;
    /** @var \PHPStan\Type\Type|null */
    private $phpDocReturnType;
    /** @var \PHPStan\Type\Type|null */
    private $phpDocThrowType;
    /** @var \PHPStan\Reflection\Php\PhpParameterReflection[]|null */
    private $parameters = null;
    /** @var \PHPStan\Type\Type|null */
    private $returnType = null;
    /** @var \PHPStan\Type\Type|null */
    private $nativeReturnType = null;
    /** @var string|null */
    private $deprecatedDescription;
    /** @var bool */
    private $isDeprecated;
    /** @var bool */
    private $isInternal;
    /** @var bool */
    private $isFinal;
    /** @var string|null */
    private $stubPhpDocString;
    /** @var FunctionVariantWithPhpDocs[]|null */
    private $variants = null;
    /**
     * @param ClassReflection $declaringClass
     * @param ClassReflection|null $declaringTrait
     * @param BuiltinMethodReflection $reflection
     * @param \PHPStan\Reflection\ReflectionProvider $reflectionProvider
     * @param Parser $parser
     * @param FunctionCallStatementFinder $functionCallStatementFinder
     * @param Cache $cache
     * @param \PHPStan\Type\Type[] $phpDocParameterTypes
     * @param Type|null $phpDocReturnType
     * @param Type|null $phpDocThrowType
     * @param string|null $deprecatedDescription
     * @param bool $isDeprecated
     * @param bool $isInternal
     * @param bool $isFinal
     * @param string|null $stubPhpDocString
     */
    public function __construct(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $declaringClass, ?\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $declaringTrait, \RectorPrefix20201227\PHPStan\Reflection\Php\BuiltinMethodReflection $reflection, \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \RectorPrefix20201227\PHPStan\Parser\Parser $parser, \RectorPrefix20201227\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \RectorPrefix20201227\PHPStan\Cache\Cache $cache, \PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\PHPStan\Type\Type $phpDocReturnType, ?\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, ?string $stubPhpDocString)
    {
        $this->declaringClass = $declaringClass;
        $this->declaringTrait = $declaringTrait;
        $this->reflection = $reflection;
        $this->reflectionProvider = $reflectionProvider;
        $this->parser = $parser;
        $this->functionCallStatementFinder = $functionCallStatementFinder;
        $this->cache = $cache;
        $this->templateTypeMap = $templateTypeMap;
        $this->phpDocParameterTypes = $phpDocParameterTypes;
        $this->phpDocReturnType = $phpDocReturnType;
        $this->phpDocThrowType = $phpDocThrowType;
        $this->deprecatedDescription = $deprecatedDescription;
        $this->isDeprecated = $isDeprecated;
        $this->isInternal = $isInternal;
        $this->isFinal = $isFinal;
        $this->stubPhpDocString = $stubPhpDocString;
    }
    public function getDeclaringClass() : \RectorPrefix20201227\PHPStan\Reflection\ClassReflection
    {
        return $this->declaringClass;
    }
    public function getDeclaringTrait() : ?\RectorPrefix20201227\PHPStan\Reflection\ClassReflection
    {
        return $this->declaringTrait;
    }
    public function getDocComment() : ?string
    {
        if ($this->stubPhpDocString !== null) {
            return $this->stubPhpDocString;
        }
        return $this->reflection->getDocComment();
    }
    /**
     * @return self|\PHPStan\Reflection\MethodPrototypeReflection
     */
    public function getPrototype() : \RectorPrefix20201227\PHPStan\Reflection\ClassMemberReflection
    {
        try {
            $prototypeMethod = $this->reflection->getPrototype();
            $prototypeDeclaringClass = $this->reflectionProvider->getClass($prototypeMethod->getDeclaringClass()->getName());
            return new \RectorPrefix20201227\PHPStan\Reflection\MethodPrototypeReflection($prototypeMethod->getName(), $prototypeDeclaringClass, $prototypeMethod->isStatic(), $prototypeMethod->isPrivate(), $prototypeMethod->isPublic(), $prototypeMethod->isAbstract(), $prototypeMethod->isFinal(), $prototypeDeclaringClass->getNativeMethod($prototypeMethod->getName())->getVariants());
        } catch (\ReflectionException $e) {
            return $this;
        }
    }
    public function isStatic() : bool
    {
        return $this->reflection->isStatic();
    }
    public function getName() : string
    {
        $name = $this->reflection->getName();
        $lowercaseName = \strtolower($name);
        if ($lowercaseName === $name) {
            // fix for https://bugs.php.net/bug.php?id=74939
            foreach ($this->getDeclaringClass()->getNativeReflection()->getTraitAliases() as $traitTarget) {
                $correctName = $this->getMethodNameWithCorrectCase($name, $traitTarget);
                if ($correctName !== null) {
                    $name = $correctName;
                    break;
                }
            }
        }
        return $name;
    }
    private function getMethodNameWithCorrectCase(string $lowercaseMethodName, string $traitTarget) : ?string
    {
        $trait = \explode('::', $traitTarget)[0];
        $traitReflection = $this->reflectionProvider->getClass($trait)->getNativeReflection();
        foreach ($traitReflection->getTraitAliases() as $methodAlias => $aliasTraitTarget) {
            if ($lowercaseMethodName === \strtolower($methodAlias)) {
                return $methodAlias;
            }
            $correctName = $this->getMethodNameWithCorrectCase($lowercaseMethodName, $aliasTraitTarget);
            if ($correctName !== null) {
                return $correctName;
            }
        }
        return null;
    }
    /**
     * @return ParametersAcceptorWithPhpDocs[]
     */
    public function getVariants() : array
    {
        if ($this->variants === null) {
            $this->variants = [new \RectorPrefix20201227\PHPStan\Reflection\FunctionVariantWithPhpDocs($this->templateTypeMap, null, $this->getParameters(), $this->isVariadic(), $this->getReturnType(), $this->getPhpDocReturnType(), $this->getNativeReturnType())];
        }
        return $this->variants;
    }
    /**
     * @return \PHPStan\Reflection\ParameterReflectionWithPhpDocs[]
     */
    private function getParameters() : array
    {
        if ($this->parameters === null) {
            $this->parameters = \array_map(function (\ReflectionParameter $reflection) : PhpParameterReflection {
                return new \RectorPrefix20201227\PHPStan\Reflection\Php\PhpParameterReflection($reflection, $this->phpDocParameterTypes[$reflection->getName()] ?? null, $this->getDeclaringClass()->getName());
            }, $this->reflection->getParameters());
        }
        return $this->parameters;
    }
    private function isVariadic() : bool
    {
        $isNativelyVariadic = $this->reflection->isVariadic();
        $declaringClass = $this->declaringClass;
        $filename = $this->declaringClass->getFileName();
        if ($this->declaringTrait !== null) {
            $declaringClass = $this->declaringTrait;
            $filename = $this->declaringTrait->getFileName();
        }
        if (!$isNativelyVariadic && $filename !== \false && \file_exists($filename)) {
            $modifiedTime = \filemtime($filename);
            if ($modifiedTime === \false) {
                $modifiedTime = \time();
            }
            $key = \sprintf('variadic-method-%s-%s-%s', $declaringClass->getName(), $this->reflection->getName(), $filename);
            $variableCacheKey = \sprintf('%d-v2', $modifiedTime);
            $cachedResult = $this->cache->load($key, $variableCacheKey);
            if ($cachedResult === null || !\is_bool($cachedResult)) {
                $nodes = $this->parser->parseFile($filename);
                $result = $this->callsFuncGetArgs($declaringClass, $nodes);
                $this->cache->save($key, $variableCacheKey, $result);
                return $result;
            }
            return $cachedResult;
        }
        return $isNativelyVariadic;
    }
    /**
     * @param ClassReflection $declaringClass
     * @param \PhpParser\Node[] $nodes
     * @return bool
     */
    private function callsFuncGetArgs(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $declaringClass, array $nodes) : bool
    {
        foreach ($nodes as $node) {
            if ($node instanceof \PhpParser\Node\Stmt\ClassLike) {
                if (!isset($node->namespacedName)) {
                    continue;
                }
                if ($declaringClass->getName() !== (string) $node->namespacedName) {
                    continue;
                }
                if ($this->callsFuncGetArgs($declaringClass, $node->stmts)) {
                    return \true;
                }
                continue;
            }
            if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
                if ($node->getStmts() === null) {
                    continue;
                    // interface
                }
                $methodName = $node->name->name;
                if ($methodName === $this->reflection->getName()) {
                    return $this->functionCallStatementFinder->findFunctionCallInStatements(\RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptor::VARIADIC_FUNCTIONS, $node->getStmts()) !== null;
                }
                continue;
            }
            if ($node instanceof \PhpParser\Node\Stmt\Function_) {
                continue;
            }
            if ($node instanceof \PhpParser\Node\Stmt\Namespace_) {
                if ($this->callsFuncGetArgs($declaringClass, $node->stmts)) {
                    return \true;
                }
                continue;
            }
            if (!$node instanceof \PhpParser\Node\Stmt\Declare_ || $node->stmts === null) {
                continue;
            }
            if ($this->callsFuncGetArgs($declaringClass, $node->stmts)) {
                return \true;
            }
        }
        return \false;
    }
    public function isPrivate() : bool
    {
        return $this->reflection->isPrivate();
    }
    public function isPublic() : bool
    {
        return $this->reflection->isPublic();
    }
    private function getReturnType() : \PHPStan\Type\Type
    {
        if ($this->returnType === null) {
            $name = \strtolower($this->getName());
            if ($name === '__construct' || $name === '__destruct' || $name === '__unset' || $name === '__wakeup' || $name === '__clone') {
                return $this->returnType = \PHPStan\Type\TypehintHelper::decideType(new \PHPStan\Type\VoidType(), $this->phpDocReturnType);
            }
            if ($name === '__tostring') {
                return $this->returnType = \PHPStan\Type\TypehintHelper::decideType(new \PHPStan\Type\StringType(), $this->phpDocReturnType);
            }
            if ($name === '__isset') {
                return $this->returnType = \PHPStan\Type\TypehintHelper::decideType(new \PHPStan\Type\BooleanType(), $this->phpDocReturnType);
            }
            if ($name === '__sleep') {
                return $this->returnType = \PHPStan\Type\TypehintHelper::decideType(new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()), $this->phpDocReturnType);
            }
            if ($name === '__set_state') {
                return $this->returnType = \PHPStan\Type\TypehintHelper::decideType(new \PHPStan\Type\ObjectWithoutClassType(), $this->phpDocReturnType);
            }
            $this->returnType = \PHPStan\Type\TypehintHelper::decideTypeFromReflection($this->reflection->getReturnType(), $this->phpDocReturnType, $this->declaringClass->getName());
        }
        return $this->returnType;
    }
    private function getPhpDocReturnType() : \PHPStan\Type\Type
    {
        if ($this->phpDocReturnType !== null) {
            return $this->phpDocReturnType;
        }
        return new \PHPStan\Type\MixedType();
    }
    private function getNativeReturnType() : \PHPStan\Type\Type
    {
        if ($this->nativeReturnType === null) {
            $this->nativeReturnType = \PHPStan\Type\TypehintHelper::decideTypeFromReflection($this->reflection->getReturnType(), null, $this->declaringClass->getName());
        }
        return $this->nativeReturnType;
    }
    public function getDeprecatedDescription() : ?string
    {
        if ($this->isDeprecated) {
            return $this->deprecatedDescription;
        }
        return null;
    }
    public function isDeprecated() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated()->or(\RectorPrefix20201227\PHPStan\TrinaryLogic::createFromBoolean($this->isDeprecated));
    }
    public function isInternal() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createFromBoolean($this->reflection->isInternal() || $this->isInternal);
    }
    public function isFinal() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createFromBoolean($this->reflection->isFinal() || $this->isFinal);
    }
    public function isAbstract() : bool
    {
        return $this->reflection->isAbstract();
    }
    public function getThrowType() : ?\PHPStan\Type\Type
    {
        return $this->phpDocThrowType;
    }
    public function hasSideEffects() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($this->getReturnType() instanceof \PHPStan\Type\VoidType) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
}
