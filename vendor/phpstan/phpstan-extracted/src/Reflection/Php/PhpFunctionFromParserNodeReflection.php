<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionVariantWithPhpDocs;
use _PhpScopere8e811afab72\PHPStan\Reflection\PassedByReference;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypehintHelper;
use _PhpScopere8e811afab72\PHPStan\Type\VoidType;
class PhpFunctionFromParserNodeReflection implements \_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection
{
    /** @var \PhpParser\Node\FunctionLike */
    private $functionLike;
    /** @var \PHPStan\Type\Generic\TemplateTypeMap */
    private $templateTypeMap;
    /** @var \PHPStan\Type\Type[] */
    private $realParameterTypes;
    /** @var \PHPStan\Type\Type[] */
    private $phpDocParameterTypes;
    /** @var \PHPStan\Type\Type[] */
    private $realParameterDefaultValues;
    /** @var \PHPStan\Type\Type */
    private $realReturnType;
    /** @var \PHPStan\Type\Type|null */
    private $phpDocReturnType;
    /** @var \PHPStan\Type\Type|null */
    private $throwType;
    /** @var string|null */
    private $deprecatedDescription;
    /** @var bool */
    private $isDeprecated;
    /** @var bool */
    private $isInternal;
    /** @var bool */
    private $isFinal;
    /** @var FunctionVariantWithPhpDocs[]|null */
    private $variants = null;
    /**
     * @param FunctionLike $functionLike
     * @param TemplateTypeMap $templateTypeMap
     * @param \PHPStan\Type\Type[] $realParameterTypes
     * @param \PHPStan\Type\Type[] $phpDocParameterTypes
     * @param \PHPStan\Type\Type[] $realParameterDefaultValues
     * @param Type $realReturnType
     * @param Type|null $phpDocReturnType
     * @param Type|null $throwType
     * @param string|null $deprecatedDescription
     * @param bool $isDeprecated
     * @param bool $isInternal
     * @param bool $isFinal
     */
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike, \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $realParameterTypes, array $phpDocParameterTypes, array $realParameterDefaultValues, \_PhpScopere8e811afab72\PHPStan\Type\Type $realReturnType, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $phpDocReturnType = null, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $throwType = null, ?string $deprecatedDescription = null, bool $isDeprecated = \false, bool $isInternal = \false, bool $isFinal = \false)
    {
        $this->functionLike = $functionLike;
        $this->templateTypeMap = $templateTypeMap;
        $this->realParameterTypes = $realParameterTypes;
        $this->phpDocParameterTypes = $phpDocParameterTypes;
        $this->realParameterDefaultValues = $realParameterDefaultValues;
        $this->realReturnType = $realReturnType;
        $this->phpDocReturnType = $phpDocReturnType;
        $this->throwType = $throwType;
        $this->deprecatedDescription = $deprecatedDescription;
        $this->isDeprecated = $isDeprecated;
        $this->isInternal = $isInternal;
        $this->isFinal = $isFinal;
    }
    protected function getFunctionLike() : \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike
    {
        return $this->functionLike;
    }
    public function getName() : string
    {
        if ($this->functionLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            return $this->functionLike->name->name;
        }
        return (string) $this->functionLike->namespacedName;
    }
    /**
     * @return \PHPStan\Reflection\ParametersAcceptorWithPhpDocs[]
     */
    public function getVariants() : array
    {
        if ($this->variants === null) {
            $this->variants = [new \_PhpScopere8e811afab72\PHPStan\Reflection\FunctionVariantWithPhpDocs($this->templateTypeMap, null, $this->getParameters(), $this->isVariadic(), $this->getReturnType(), $this->phpDocReturnType ?? new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), $this->realReturnType)];
        }
        return $this->variants;
    }
    /**
     * @return \PHPStan\Reflection\ParameterReflectionWithPhpDocs[]
     */
    private function getParameters() : array
    {
        $parameters = [];
        $isOptional = \true;
        /** @var \PhpParser\Node\Param $parameter */
        foreach (\array_reverse($this->functionLike->getParams()) as $parameter) {
            if ($parameter->default === null && !$parameter->variadic) {
                $isOptional = \false;
            }
            if (!$parameter->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable || !\is_string($parameter->var->name)) {
                throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
            }
            $parameters[] = new \_PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpParameterFromParserNodeReflection($parameter->var->name, $isOptional, $this->realParameterTypes[$parameter->var->name], $this->phpDocParameterTypes[$parameter->var->name] ?? null, $parameter->byRef ? \_PhpScopere8e811afab72\PHPStan\Reflection\PassedByReference::createCreatesNewVariable() : \_PhpScopere8e811afab72\PHPStan\Reflection\PassedByReference::createNo(), $this->realParameterDefaultValues[$parameter->var->name] ?? null, $parameter->variadic);
        }
        return \array_reverse($parameters);
    }
    private function isVariadic() : bool
    {
        foreach ($this->functionLike->getParams() as $parameter) {
            if ($parameter->variadic) {
                return \true;
            }
        }
        return \false;
    }
    protected function getReturnType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\TypehintHelper::decideType($this->realReturnType, $this->phpDocReturnType);
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
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($this->isDeprecated);
    }
    public function isInternal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($this->isInternal);
    }
    public function isFinal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        $finalMethod = \false;
        if ($this->functionLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            $finalMethod = $this->functionLike->isFinal();
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($finalMethod || $this->isFinal);
    }
    public function getThrowType() : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->throwType;
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
        return \false;
    }
}
