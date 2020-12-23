<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection\Php;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Declare_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a2ac50786fa\PHPStan\Cache\Cache;
use _PhpScoper0a2ac50786fa\PHPStan\Parser\FunctionCallStatementFinder;
use _PhpScoper0a2ac50786fa\PHPStan\Parser\Parser;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionVariantWithPhpDocs;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodPrototypeReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptor;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorWithPhpDocs;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\StringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypehintHelper;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VoidType;
class PhpMethodReflection implements \_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection
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
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $declaringClass, ?\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $declaringTrait, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Php\BuiltinMethodReflection $reflection, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoper0a2ac50786fa\PHPStan\Parser\Parser $parser, \_PhpScoper0a2ac50786fa\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \_PhpScoper0a2ac50786fa\PHPStan\Cache\Cache $cache, \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $phpDocReturnType, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, ?string $stubPhpDocString)
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
    public function getDeclaringClass() : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection
    {
        return $this->declaringClass;
    }
    public function getDeclaringTrait() : ?\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection
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
    public function getPrototype() : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberReflection
    {
        try {
            $prototypeMethod = $this->reflection->getPrototype();
            $prototypeDeclaringClass = $this->reflectionProvider->getClass($prototypeMethod->getDeclaringClass()->getName());
            return new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodPrototypeReflection($prototypeMethod->getName(), $prototypeDeclaringClass, $prototypeMethod->isStatic(), $prototypeMethod->isPrivate(), $prototypeMethod->isPublic(), $prototypeMethod->isAbstract(), $prototypeMethod->isFinal(), $prototypeDeclaringClass->getNativeMethod($prototypeMethod->getName())->getVariants());
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
            $this->variants = [new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionVariantWithPhpDocs($this->templateTypeMap, null, $this->getParameters(), $this->isVariadic(), $this->getReturnType(), $this->getPhpDocReturnType(), $this->getNativeReturnType())];
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
                return new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Php\PhpParameterReflection($reflection, $this->phpDocParameterTypes[$reflection->getName()] ?? null, $this->getDeclaringClass()->getName());
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
    private function callsFuncGetArgs(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $declaringClass, array $nodes) : bool
    {
        foreach ($nodes as $node) {
            if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike) {
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
            if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod) {
                if ($node->getStmts() === null) {
                    continue;
                    // interface
                }
                $methodName = $node->name->name;
                if ($methodName === $this->reflection->getName()) {
                    return $this->functionCallStatementFinder->findFunctionCallInStatements(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptor::VARIADIC_FUNCTIONS, $node->getStmts()) !== null;
                }
                continue;
            }
            if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_) {
                continue;
            }
            if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_) {
                if ($this->callsFuncGetArgs($declaringClass, $node->stmts)) {
                    return \true;
                }
                continue;
            }
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Declare_ || $node->stmts === null) {
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
    private function getReturnType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($this->returnType === null) {
            $name = \strtolower($this->getName());
            if ($name === '__construct' || $name === '__destruct' || $name === '__unset' || $name === '__wakeup' || $name === '__clone') {
                return $this->returnType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypehintHelper::decideType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType(), $this->phpDocReturnType);
            }
            if ($name === '__tostring') {
                return $this->returnType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypehintHelper::decideType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType(), $this->phpDocReturnType);
            }
            if ($name === '__isset') {
                return $this->returnType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypehintHelper::decideType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType(), $this->phpDocReturnType);
            }
            if ($name === '__sleep') {
                return $this->returnType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypehintHelper::decideType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType()), $this->phpDocReturnType);
            }
            if ($name === '__set_state') {
                return $this->returnType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypehintHelper::decideType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType(), $this->phpDocReturnType);
            }
            $this->returnType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypehintHelper::decideTypeFromReflection($this->reflection->getReturnType(), $this->phpDocReturnType, $this->declaringClass->getName());
        }
        return $this->returnType;
    }
    private function getPhpDocReturnType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($this->phpDocReturnType !== null) {
            return $this->phpDocReturnType;
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
    }
    private function getNativeReturnType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($this->nativeReturnType === null) {
            $this->nativeReturnType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypehintHelper::decideTypeFromReflection($this->reflection->getReturnType(), null, $this->declaringClass->getName());
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
    public function isDeprecated() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated()->or(\_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createFromBoolean($this->isDeprecated));
    }
    public function isInternal() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createFromBoolean($this->reflection->isInternal() || $this->isInternal);
    }
    public function isFinal() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createFromBoolean($this->reflection->isFinal() || $this->isFinal);
    }
    public function isAbstract() : bool
    {
        return $this->reflection->isAbstract();
    }
    public function getThrowType() : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->phpDocThrowType;
    }
    public function hasSideEffects() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($this->getReturnType() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
    }
}
