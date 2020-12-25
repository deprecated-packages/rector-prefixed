<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Analyser\OutOfClassScope;
use PHPStan\Reflection\ClassMemberAccessAnswerer;
use PHPStan\Reflection\Native\NativeParameterReflection;
use PHPStan\Reflection\ParameterReflection;
use PHPStan\Reflection\ParametersAcceptor;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Generic\TemplateTypeVariance;
use PHPStan\Type\Traits\MaybeIterableTypeTrait;
use PHPStan\Type\Traits\MaybeObjectTypeTrait;
use PHPStan\Type\Traits\MaybeOffsetAccessibleTypeTrait;
use PHPStan\Type\Traits\TruthyBooleanTypeTrait;
use PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
class CallableType implements \PHPStan\Type\CompoundType, \PHPStan\Reflection\ParametersAcceptor
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
    public function __construct(?array $parameters = null, ?\PHPStan\Type\Type $returnType = null, bool $variadic = \true)
    {
        $this->parameters = $parameters ?? [];
        $this->returnType = $returnType ?? new \PHPStan\Type\MixedType();
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
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof \PHPStan\Type\CompoundType && !$type instanceof self) {
            return \PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return $this->isSuperTypeOfInternal($type, \true);
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \PHPStan\TrinaryLogic
    {
        return $this->isSuperTypeOfInternal($type, \false);
    }
    private function isSuperTypeOfInternal(\PHPStan\Type\Type $type, bool $treatMixedAsAny) : \PHPStan\TrinaryLogic
    {
        $isCallable = $type->isCallable();
        if ($isCallable->no() || $this->isCommonCallable) {
            return $isCallable;
        }
        static $scope;
        if ($scope === null) {
            $scope = new \PHPStan\Analyser\OutOfClassScope();
        }
        $variantsResult = null;
        foreach ($type->getCallableParametersAcceptors($scope) as $variant) {
            $isSuperType = \PHPStan\Type\CallableTypeHelper::isParametersAcceptorSuperTypeOf($this, $variant, $treatMixedAsAny);
            if ($variantsResult === null) {
                $variantsResult = $isSuperType;
            } else {
                $variantsResult = $variantsResult->or($isSuperType);
            }
        }
        if ($variantsResult === null) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        return $isCallable->and($variantsResult);
    }
    public function isSubTypeOf(\PHPStan\Type\Type $otherType) : \PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \PHPStan\Type\IntersectionType || $otherType instanceof \PHPStan\Type\UnionType) {
            return $otherType->isSuperTypeOf($this);
        }
        return $otherType->isCallable()->and($otherType instanceof self ? \PHPStan\TrinaryLogic::createYes() : \PHPStan\TrinaryLogic::createMaybe());
    }
    public function isAcceptedBy(\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function equals(\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self;
    }
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(static function () : string {
            return 'callable';
        }, function () use($level) : string {
            return \sprintf('callable(%s): %s', \implode(', ', \array_map(static function (\PHPStan\Reflection\Native\NativeParameterReflection $param) use($level) : string {
                return \sprintf('%s%s', $param->isVariadic() ? '...' : '', $param->getType()->describe($level));
            }, $this->getParameters())), $this->returnType->describe($level));
        });
    }
    public function isCallable() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return [$this];
    }
    public function toNumber() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toString() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toInteger() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toFloat() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toArray() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
    }
    public function getTemplateTypeMap() : \PHPStan\Type\Generic\TemplateTypeMap
    {
        return \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getResolvedTemplateTypeMap() : \PHPStan\Type\Generic\TemplateTypeMap
    {
        return \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
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
    public function getReturnType() : \PHPStan\Type\Type
    {
        return $this->returnType;
    }
    public function inferTemplateTypes(\PHPStan\Type\Type $receivedType) : \PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \PHPStan\Type\UnionType || $receivedType instanceof \PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if ($receivedType->isCallable()->no()) {
            return \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        $parametersAcceptors = $receivedType->getCallableParametersAcceptors(new \PHPStan\Analyser\OutOfClassScope());
        $typeMap = \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($parametersAcceptors as $parametersAcceptor) {
            $typeMap = $typeMap->union($this->inferTemplateTypesOnParametersAcceptor($receivedType, $parametersAcceptor));
        }
        return $typeMap;
    }
    private function inferTemplateTypesOnParametersAcceptor(\PHPStan\Type\Type $receivedType, \PHPStan\Reflection\ParametersAcceptor $parametersAcceptor) : \PHPStan\Type\Generic\TemplateTypeMap
    {
        $typeMap = \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        $args = $parametersAcceptor->getParameters();
        $returnType = $parametersAcceptor->getReturnType();
        foreach ($this->getParameters() as $i => $param) {
            $argType = isset($args[$i]) ? $args[$i]->getType() : new \PHPStan\Type\NeverType();
            $paramType = $param->getType();
            $typeMap = $typeMap->union($paramType->inferTemplateTypes($argType));
        }
        return $typeMap->union($this->getReturnType()->inferTemplateTypes($returnType));
    }
    public function getReferencedTemplateTypes(\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $references = $this->getReturnType()->getReferencedTemplateTypes($positionVariance->compose(\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant()));
        $paramVariance = $positionVariance->compose(\PHPStan\Type\Generic\TemplateTypeVariance::createContravariant());
        foreach ($this->getParameters() as $param) {
            foreach ($param->getType()->getReferencedTemplateTypes($paramVariance) as $reference) {
                $references[] = $reference;
            }
        }
        return $references;
    }
    public function traverse(callable $cb) : \PHPStan\Type\Type
    {
        if ($this->isCommonCallable) {
            return $this;
        }
        $parameters = \array_map(static function (\PHPStan\Reflection\ParameterReflection $param) use($cb) : NativeParameterReflection {
            $defaultValue = $param->getDefaultValue();
            return new \PHPStan\Reflection\Native\NativeParameterReflection($param->getName(), $param->isOptional(), $cb($param->getType()), $param->passedByReference(), $param->isVariadic(), $defaultValue !== null ? $cb($defaultValue) : null);
        }, $this->getParameters());
        return new self($parameters, $cb($this->getReturnType()), $this->isVariadic());
    }
    public function isArray() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function isNumericString() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \PHPStan\Type\Type
    {
        return new self((bool) $properties['isCommonCallable'] ? null : $properties['parameters'], (bool) $properties['isCommonCallable'] ? null : $properties['returnType'], $properties['variadic']);
    }
}
