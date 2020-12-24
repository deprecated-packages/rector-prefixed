<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Declare_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_;
use _PhpScopere8e811afab72\PHPStan\Cache\Cache;
use _PhpScopere8e811afab72\PHPStan\Parser\FunctionCallStatementFinder;
use _PhpScopere8e811afab72\PHPStan\Parser\Parser;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionVariantWithPhpDocs;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodPrototypeReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptor;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorWithPhpDocs;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypehintHelper;
use _PhpScopere8e811afab72\PHPStan\Type\VoidType;
class PhpMethodReflection implements \_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection
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
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $declaringClass, ?\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $declaringTrait, \_PhpScopere8e811afab72\PHPStan\Reflection\Php\BuiltinMethodReflection $reflection, \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScopere8e811afab72\PHPStan\Parser\Parser $parser, \_PhpScopere8e811afab72\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \_PhpScopere8e811afab72\PHPStan\Cache\Cache $cache, \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $phpDocReturnType, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, ?string $stubPhpDocString)
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
    public function getDeclaringClass() : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
    {
        return $this->declaringClass;
    }
    public function getDeclaringTrait() : ?\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
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
    public function getPrototype() : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberReflection
    {
        try {
            $prototypeMethod = $this->reflection->getPrototype();
            $prototypeDeclaringClass = $this->reflectionProvider->getClass($prototypeMethod->getDeclaringClass()->getName());
            return new \_PhpScopere8e811afab72\PHPStan\Reflection\MethodPrototypeReflection($prototypeMethod->getName(), $prototypeDeclaringClass, $prototypeMethod->isStatic(), $prototypeMethod->isPrivate(), $prototypeMethod->isPublic(), $prototypeMethod->isAbstract(), $prototypeMethod->isFinal(), $prototypeDeclaringClass->getNativeMethod($prototypeMethod->getName())->getVariants());
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
            $this->variants = [new \_PhpScopere8e811afab72\PHPStan\Reflection\FunctionVariantWithPhpDocs($this->templateTypeMap, null, $this->getParameters(), $this->isVariadic(), $this->getReturnType(), $this->getPhpDocReturnType(), $this->getNativeReturnType())];
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
                return new \_PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpParameterReflection($reflection, $this->phpDocParameterTypes[$reflection->getName()] ?? null, $this->getDeclaringClass()->getName());
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
    private function callsFuncGetArgs(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $declaringClass, array $nodes) : bool
    {
        foreach ($nodes as $node) {
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike) {
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
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
                if ($node->getStmts() === null) {
                    continue;
                    // interface
                }
                $methodName = $node->name->name;
                if ($methodName === $this->reflection->getName()) {
                    return $this->functionCallStatementFinder->findFunctionCallInStatements(\_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptor::VARIADIC_FUNCTIONS, $node->getStmts()) !== null;
                }
                continue;
            }
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_) {
                continue;
            }
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_) {
                if ($this->callsFuncGetArgs($declaringClass, $node->stmts)) {
                    return \true;
                }
                continue;
            }
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Declare_ || $node->stmts === null) {
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
    private function getReturnType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($this->returnType === null) {
            $name = \strtolower($this->getName());
            if ($name === '__construct' || $name === '__destruct' || $name === '__unset' || $name === '__wakeup' || $name === '__clone') {
                return $this->returnType = \_PhpScopere8e811afab72\PHPStan\Type\TypehintHelper::decideType(new \_PhpScopere8e811afab72\PHPStan\Type\VoidType(), $this->phpDocReturnType);
            }
            if ($name === '__tostring') {
                return $this->returnType = \_PhpScopere8e811afab72\PHPStan\Type\TypehintHelper::decideType(new \_PhpScopere8e811afab72\PHPStan\Type\StringType(), $this->phpDocReturnType);
            }
            if ($name === '__isset') {
                return $this->returnType = \_PhpScopere8e811afab72\PHPStan\Type\TypehintHelper::decideType(new \_PhpScopere8e811afab72\PHPStan\Type\BooleanType(), $this->phpDocReturnType);
            }
            if ($name === '__sleep') {
                return $this->returnType = \_PhpScopere8e811afab72\PHPStan\Type\TypehintHelper::decideType(new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\StringType()), $this->phpDocReturnType);
            }
            if ($name === '__set_state') {
                return $this->returnType = \_PhpScopere8e811afab72\PHPStan\Type\TypehintHelper::decideType(new \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType(), $this->phpDocReturnType);
            }
            $this->returnType = \_PhpScopere8e811afab72\PHPStan\Type\TypehintHelper::decideTypeFromReflection($this->reflection->getReturnType(), $this->phpDocReturnType, $this->declaringClass->getName());
        }
        return $this->returnType;
    }
    private function getPhpDocReturnType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($this->phpDocReturnType !== null) {
            return $this->phpDocReturnType;
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
    private function getNativeReturnType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($this->nativeReturnType === null) {
            $this->nativeReturnType = \_PhpScopere8e811afab72\PHPStan\Type\TypehintHelper::decideTypeFromReflection($this->reflection->getReturnType(), null, $this->declaringClass->getName());
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
    public function isDeprecated() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated()->or(\_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($this->isDeprecated));
    }
    public function isInternal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($this->reflection->isInternal() || $this->isInternal);
    }
    public function isFinal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($this->reflection->isFinal() || $this->isFinal);
    }
    public function isAbstract() : bool
    {
        return $this->reflection->isAbstract();
    }
    public function getThrowType() : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->phpDocThrowType;
    }
    public function hasSideEffects() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($this->getReturnType() instanceof \_PhpScopere8e811afab72\PHPStan\Type\VoidType) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
}
