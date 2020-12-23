<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

use _PhpScoper0a2ac50786fa\PHPStan\Analyser\OutOfClassScope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\Native\NativeParameterReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParameterReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptor;
use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeVariance;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\MaybeIterableTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\MaybeObjectTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\MaybeOffsetAccessibleTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\TruthyBooleanTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
class CallableType implements \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptor
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
    public function __construct(?array $parameters = null, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $returnType = null, bool $variadic = \true)
    {
        $this->parameters = $parameters ?? [];
        $this->returnType = $returnType ?? new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
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
    public function accepts(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType && !$type instanceof self) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return $this->isSuperTypeOfInternal($type, \true);
    }
    public function isSuperTypeOf(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->isSuperTypeOfInternal($type, \false);
    }
    private function isSuperTypeOfInternal(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, bool $treatMixedAsAny) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        $isCallable = $type->isCallable();
        if ($isCallable->no() || $this->isCommonCallable) {
            return $isCallable;
        }
        static $scope;
        if ($scope === null) {
            $scope = new \_PhpScoper0a2ac50786fa\PHPStan\Analyser\OutOfClassScope();
        }
        $variantsResult = null;
        foreach ($type->getCallableParametersAcceptors($scope) as $variant) {
            $isSuperType = \_PhpScoper0a2ac50786fa\PHPStan\Type\CallableTypeHelper::isParametersAcceptorSuperTypeOf($this, $variant, $treatMixedAsAny);
            if ($variantsResult === null) {
                $variantsResult = $isSuperType;
            } else {
                $variantsResult = $variantsResult->or($isSuperType);
            }
        }
        if ($variantsResult === null) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
        }
        return $isCallable->and($variantsResult);
    }
    public function isSubTypeOf(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $otherType) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType || $otherType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
            return $otherType->isSuperTypeOf($this);
        }
        return $otherType->isCallable()->and($otherType instanceof self ? \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe());
    }
    public function isAcceptedBy(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function equals(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self;
    }
    public function describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(static function () : string {
            return 'callable';
        }, function () use($level) : string {
            return \sprintf('callable(%s): %s', \implode(', ', \array_map(static function (\_PhpScoper0a2ac50786fa\PHPStan\Reflection\Native\NativeParameterReflection $param) use($level) : string {
                return \sprintf('%s%s', $param->isVariadic() ? '...' : '', $param->getType()->describe($level));
            }, $this->getParameters())), $this->returnType->describe($level));
        });
    }
    public function isCallable() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return [$this];
    }
    public function toNumber() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function toString() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function toInteger() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function toFloat() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function toArray() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType());
    }
    public function getTemplateTypeMap() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getResolvedTemplateTypeMap() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
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
    public function getReturnType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->returnType;
    }
    public function inferTemplateTypes(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $receivedType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType || $receivedType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if ($receivedType->isCallable()->no()) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        $parametersAcceptors = $receivedType->getCallableParametersAcceptors(new \_PhpScoper0a2ac50786fa\PHPStan\Analyser\OutOfClassScope());
        $typeMap = \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($parametersAcceptors as $parametersAcceptor) {
            $typeMap = $typeMap->union($this->inferTemplateTypesOnParametersAcceptor($receivedType, $parametersAcceptor));
        }
        return $typeMap;
    }
    private function inferTemplateTypesOnParametersAcceptor(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $receivedType, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap
    {
        $typeMap = \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        $args = $parametersAcceptor->getParameters();
        $returnType = $parametersAcceptor->getReturnType();
        foreach ($this->getParameters() as $i => $param) {
            $argType = isset($args[$i]) ? $args[$i]->getType() : new \_PhpScoper0a2ac50786fa\PHPStan\Type\NeverType();
            $paramType = $param->getType();
            $typeMap = $typeMap->union($paramType->inferTemplateTypes($argType));
        }
        return $typeMap->union($this->getReturnType()->inferTemplateTypes($returnType));
    }
    public function getReferencedTemplateTypes(\_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $references = $this->getReturnType()->getReferencedTemplateTypes($positionVariance->compose(\_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant()));
        $paramVariance = $positionVariance->compose(\_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeVariance::createContravariant());
        foreach ($this->getParameters() as $param) {
            foreach ($param->getType()->getReferencedTemplateTypes($paramVariance) as $reference) {
                $references[] = $reference;
            }
        }
        return $references;
    }
    public function traverse(callable $cb) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($this->isCommonCallable) {
            return $this;
        }
        $parameters = \array_map(static function (\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParameterReflection $param) use($cb) : NativeParameterReflection {
            $defaultValue = $param->getDefaultValue();
            return new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Native\NativeParameterReflection($param->getName(), $param->isOptional(), $cb($param->getType()), $param->passedByReference(), $param->isVariadic(), $defaultValue !== null ? $cb($defaultValue) : null);
        }, $this->getParameters());
        return new self($parameters, $cb($this->getReturnType()), $this->isVariadic());
    }
    public function isArray() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isNumericString() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new self((bool) $properties['isCommonCallable'] ? null : $properties['parameters'], (bool) $properties['isCommonCallable'] ? null : $properties['returnType'], $properties['variadic']);
    }
}
