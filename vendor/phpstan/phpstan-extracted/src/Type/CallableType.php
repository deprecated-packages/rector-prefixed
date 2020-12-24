<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\Analyser\OutOfClassScope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScopere8e811afab72\PHPStan\Reflection\Native\NativeParameterReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParameterReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptor;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\MaybeIterableTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\MaybeObjectTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\MaybeOffsetAccessibleTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\TruthyBooleanTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
class CallableType implements \_PhpScopere8e811afab72\PHPStan\Type\CompoundType, \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptor
{
    use MaybeIterableTypeTrait;
    use MaybeObjectTypeTrait;
    use MaybeOffsetAccessibleTypeTrait;
    use TruthyBooleanTypeTrait;
    use UndecidedComparisonCompoundTypeTrait;
    /** @var array<int, \PHPStan\Reflection\ParameterReflection> */
    private $parameters;
    /** @var Type */
    private $returnType;
    /** @var bool */
    private $variadic;
    /** @var bool */
    private $isCommonCallable;
    /**
     * @param array<int, \PHPStan\Reflection\ParameterReflection> $parameters
     * @param Type $returnType
     * @param bool $variadic
     */
    public function __construct(?array $parameters = null, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $returnType = null, bool $variadic = \true)
    {
        $this->parameters = $parameters ?? [];
        $this->returnType = $returnType ?? new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        $this->variadic = $variadic;
        $this->isCommonCallable = $parameters === null && $returnType === null;
    }
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        return [];
    }
    public function accepts(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\CompoundType && !$type instanceof self) {
            return \_PhpScopere8e811afab72\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return $this->isSuperTypeOfInternal($type, \true);
    }
    public function isSuperTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->isSuperTypeOfInternal($type, \false);
    }
    private function isSuperTypeOfInternal(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, bool $treatMixedAsAny) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        $isCallable = $type->isCallable();
        if ($isCallable->no() || $this->isCommonCallable) {
            return $isCallable;
        }
        static $scope;
        if ($scope === null) {
            $scope = new \_PhpScopere8e811afab72\PHPStan\Analyser\OutOfClassScope();
        }
        $variantsResult = null;
        foreach ($type->getCallableParametersAcceptors($scope) as $variant) {
            $isSuperType = \_PhpScopere8e811afab72\PHPStan\Type\CallableTypeHelper::isParametersAcceptorSuperTypeOf($this, $variant, $treatMixedAsAny);
            if ($variantsResult === null) {
                $variantsResult = $isSuperType;
            } else {
                $variantsResult = $variantsResult->or($isSuperType);
            }
        }
        if ($variantsResult === null) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        return $isCallable->and($variantsResult);
    }
    public function isSubTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $otherType) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType || $otherType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return $otherType->isSuperTypeOf($this);
        }
        return $otherType->isCallable()->and($otherType instanceof self ? \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe());
    }
    public function isAcceptedBy(\_PhpScopere8e811afab72\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function equals(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self;
    }
    public function describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(static function () : string {
            return 'callable';
        }, function () use($level) : string {
            return \sprintf('callable(%s): %s', \implode(', ', \array_map(static function (\_PhpScopere8e811afab72\PHPStan\Reflection\Native\NativeParameterReflection $param) use($level) : string {
                return \sprintf('%s%s', $param->isVariadic() ? '...' : '', $param->getType()->describe($level));
            }, $this->getParameters())), $this->returnType->describe($level));
        });
    }
    public function isCallable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return [$this];
    }
    public function toNumber() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function toString() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function toInteger() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function toFloat() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function toArray() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
    }
    public function getTemplateTypeMap() : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getResolvedTemplateTypeMap() : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    /**
     * @return array<int, \PHPStan\Reflection\ParameterReflection>
     */
    public function getParameters() : array
    {
        return $this->parameters;
    }
    public function isVariadic() : bool
    {
        return $this->variadic;
    }
    public function getReturnType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->returnType;
    }
    public function inferTemplateTypes(\_PhpScopere8e811afab72\PHPStan\Type\Type $receivedType) : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType || $receivedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if ($receivedType->isCallable()->no()) {
            return \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        $parametersAcceptors = $receivedType->getCallableParametersAcceptors(new \_PhpScopere8e811afab72\PHPStan\Analyser\OutOfClassScope());
        $typeMap = \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($parametersAcceptors as $parametersAcceptor) {
            $typeMap = $typeMap->union($this->inferTemplateTypesOnParametersAcceptor($receivedType, $parametersAcceptor));
        }
        return $typeMap;
    }
    private function inferTemplateTypesOnParametersAcceptor(\_PhpScopere8e811afab72\PHPStan\Type\Type $receivedType, \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor) : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap
    {
        $typeMap = \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        $args = $parametersAcceptor->getParameters();
        $returnType = $parametersAcceptor->getReturnType();
        foreach ($this->getParameters() as $i => $param) {
            $argType = isset($args[$i]) ? $args[$i]->getType() : new \_PhpScopere8e811afab72\PHPStan\Type\NeverType();
            $paramType = $param->getType();
            $typeMap = $typeMap->union($paramType->inferTemplateTypes($argType));
        }
        return $typeMap->union($this->getReturnType()->inferTemplateTypes($returnType));
    }
    public function getReferencedTemplateTypes(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $references = $this->getReturnType()->getReferencedTemplateTypes($positionVariance->compose(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant()));
        $paramVariance = $positionVariance->compose(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance::createContravariant());
        foreach ($this->getParameters() as $param) {
            foreach ($param->getType()->getReferencedTemplateTypes($paramVariance) as $reference) {
                $references[] = $reference;
            }
        }
        return $references;
    }
    public function traverse(callable $cb) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($this->isCommonCallable) {
            return $this;
        }
        $parameters = \array_map(static function (\_PhpScopere8e811afab72\PHPStan\Reflection\ParameterReflection $param) use($cb) : NativeParameterReflection {
            $defaultValue = $param->getDefaultValue();
            return new \_PhpScopere8e811afab72\PHPStan\Reflection\Native\NativeParameterReflection($param->getName(), $param->isOptional(), $cb($param->getType()), $param->passedByReference(), $param->isVariadic(), $defaultValue !== null ? $cb($defaultValue) : null);
        }, $this->getParameters());
        return new self($parameters, $cb($this->getReturnType()), $this->isVariadic());
    }
    public function isArray() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isNumericString() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new self((bool) $properties['isCommonCallable'] ? null : $properties['parameters'], (bool) $properties['isCommonCallable'] ? null : $properties['returnType'], $properties['variadic']);
    }
}
