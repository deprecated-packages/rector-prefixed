<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Declare_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_;
use _PhpScopere8e811afab72\PHPStan\Cache\Cache;
use _PhpScopere8e811afab72\PHPStan\Parser\FunctionCallStatementFinder;
use _PhpScopere8e811afab72\PHPStan\Parser\Parser;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionVariantWithPhpDocs;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptor;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorWithPhpDocs;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionWithFilename;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypehintHelper;
use _PhpScopere8e811afab72\PHPStan\Type\VoidType;
class PhpFunctionReflection implements \_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection, \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionWithFilename
{
    /** @var \ReflectionFunction */
    private $reflection;
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
    /** @var string|null */
    private $deprecatedDescription;
    /** @var bool */
    private $isDeprecated;
    /** @var bool */
    private $isInternal;
    /** @var bool */
    private $isFinal;
    /** @var string|false */
    private $filename;
    /** @var FunctionVariantWithPhpDocs[]|null */
    private $variants = null;
    /**
     * @param \ReflectionFunction $reflection
     * @param Parser $parser
     * @param FunctionCallStatementFinder $functionCallStatementFinder
     * @param Cache $cache
     * @param TemplateTypeMap $templateTypeMap
     * @param \PHPStan\Type\Type[] $phpDocParameterTypes
     * @param Type|null $phpDocReturnType
     * @param Type|null $phpDocThrowType
     * @param string|null $deprecatedDescription
     * @param bool $isDeprecated
     * @param bool $isInternal
     * @param bool $isFinal
     * @param string|false $filename
     */
    public function __construct(\ReflectionFunction $reflection, \_PhpScopere8e811afab72\PHPStan\Parser\Parser $parser, \_PhpScopere8e811afab72\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \_PhpScopere8e811afab72\PHPStan\Cache\Cache $cache, \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $phpDocReturnType, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, $filename)
    {
        $this->reflection = $reflection;
        $this->parser = $parser;
        $this->functionCallStatementFinder = $functionCallStatementFinder;
        $this->cache = $cache;
        $this->templateTypeMap = $templateTypeMap;
        $this->phpDocParameterTypes = $phpDocParameterTypes;
        $this->phpDocReturnType = $phpDocReturnType;
        $this->phpDocThrowType = $phpDocThrowType;
        $this->isDeprecated = $isDeprecated;
        $this->deprecatedDescription = $deprecatedDescription;
        $this->isInternal = $isInternal;
        $this->isFinal = $isFinal;
        $this->filename = $filename;
    }
    public function getName() : string
    {
        return $this->reflection->getName();
    }
    /**
     * @return string|false
     */
    public function getFileName()
    {
        if ($this->filename === \false) {
            return \false;
        }
        if (!\file_exists($this->filename)) {
            return \false;
        }
        return $this->filename;
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
        return \array_map(function (\ReflectionParameter $reflection) : PhpParameterReflection {
            return new \_PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpParameterReflection($reflection, $this->phpDocParameterTypes[$reflection->getName()] ?? null, null);
        }, $this->reflection->getParameters());
    }
    private function isVariadic() : bool
    {
        $isNativelyVariadic = $this->reflection->isVariadic();
        if (!$isNativelyVariadic && $this->reflection->getFileName() !== \false) {
            $fileName = $this->reflection->getFileName();
            if (\file_exists($fileName)) {
                $functionName = $this->reflection->getName();
                $modifiedTime = \filemtime($fileName);
                if ($modifiedTime === \false) {
                    $modifiedTime = \time();
                }
                $variableCacheKey = \sprintf('%d-v1', $modifiedTime);
                $key = \sprintf('variadic-function-%s-%s', $functionName, $fileName);
                $cachedResult = $this->cache->load($key, $variableCacheKey);
                if ($cachedResult === null) {
                    $nodes = $this->parser->parseFile($fileName);
                    $result = $this->callsFuncGetArgs($nodes);
                    $this->cache->save($key, $variableCacheKey, $result);
                    return $result;
                }
                return $cachedResult;
            }
        }
        return $isNativelyVariadic;
    }
    /**
     * @param \PhpParser\Node[] $nodes
     * @return bool
     */
    private function callsFuncGetArgs(array $nodes) : bool
    {
        foreach ($nodes as $node) {
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_) {
                $functionName = (string) $node->namespacedName;
                if ($functionName === $this->reflection->getName()) {
                    return $this->functionCallStatementFinder->findFunctionCallInStatements(\_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptor::VARIADIC_FUNCTIONS, $node->getStmts()) !== null;
                }
                continue;
            }
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike) {
                continue;
            }
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_) {
                if ($this->callsFuncGetArgs($node->stmts)) {
                    return \true;
                }
            }
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Declare_ || $node->stmts === null) {
                continue;
            }
            if ($this->callsFuncGetArgs($node->stmts)) {
                return \true;
            }
        }
        return \false;
    }
    private function getReturnType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\TypehintHelper::decideTypeFromReflection($this->reflection->getReturnType(), $this->phpDocReturnType);
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
        return \_PhpScopere8e811afab72\PHPStan\Type\TypehintHelper::decideTypeFromReflection($this->reflection->getReturnType());
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
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($this->isDeprecated || $this->reflection->isDeprecated());
    }
    public function isInternal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($this->isInternal);
    }
    public function isFinal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($this->isFinal);
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
    public function isBuiltin() : bool
    {
        return $this->reflection->isInternal();
    }
}
