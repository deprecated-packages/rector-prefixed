<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type;

use _PhpScoperb75b35f52b74\PHPStan\Analyser\OutOfClassScope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Native\NativeParameterReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParameterReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptor;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\MaybeIterableTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\MaybeObjectTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\MaybeOffsetAccessibleTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\TruthyBooleanTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
class CallableType implements \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptor
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
    public function __construct(?array $parameters = null, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $returnType = null, bool $variadic = \true)
    {
        $this->parameters = $parameters ?? [];
        $this->returnType = $returnType ?? new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
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
    public function accepts(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType && !$type instanceof self) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return $this->isSuperTypeOfInternal($type, \true);
    }
    public function isSuperTypeOf(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->isSuperTypeOfInternal($type, \false);
    }
    private function isSuperTypeOfInternal(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, bool $treatMixedAsAny) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        $isCallable = $type->isCallable();
        if ($isCallable->no() || $this->isCommonCallable) {
            return $isCallable;
        }
        static $scope;
        if ($scope === null) {
            $scope = new \_PhpScoperb75b35f52b74\PHPStan\Analyser\OutOfClassScope();
        }
        $variantsResult = null;
        foreach ($type->getCallableParametersAcceptors($scope) as $variant) {
            $isSuperType = \_PhpScoperb75b35f52b74\PHPStan\Type\CallableTypeHelper::isParametersAcceptorSuperTypeOf($this, $variant, $treatMixedAsAny);
            if ($variantsResult === null) {
                $variantsResult = $isSuperType;
            } else {
                $variantsResult = $variantsResult->or($isSuperType);
            }
        }
        if ($variantsResult === null) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        return $isCallable->and($variantsResult);
    }
    public function isSubTypeOf(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $otherType) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType || $otherType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            return $otherType->isSuperTypeOf($this);
        }
        return $otherType->isCallable()->and($otherType instanceof self ? \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe());
    }
    public function isAcceptedBy(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function equals(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self;
    }
    public function describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(static function () : string {
            return 'callable';
        }, function () use($level) : string {
            return \sprintf('callable(%s): %s', \implode(', ', \array_map(static function (\_PhpScoperb75b35f52b74\PHPStan\Reflection\Native\NativeParameterReflection $param) use($level) : string {
                return \sprintf('%s%s', $param->isVariadic() ? '...' : '', $param->getType()->describe($level));
            }, $this->getParameters())), $this->returnType->describe($level));
        });
    }
    public function isCallable() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return [$this];
    }
    public function toNumber() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
    }
    public function toString() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
    }
    public function toInteger() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
    }
    public function toFloat() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
    }
    public function toArray() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType());
    }
    public function getTemplateTypeMap() : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getResolvedTemplateTypeMap() : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
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
    public function getReturnType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->returnType;
    }
    public function inferTemplateTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $receivedType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType || $receivedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if ($receivedType->isCallable()->no()) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        $parametersAcceptors = $receivedType->getCallableParametersAcceptors(new \_PhpScoperb75b35f52b74\PHPStan\Analyser\OutOfClassScope());
        $typeMap = \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($parametersAcceptors as $parametersAcceptor) {
            $typeMap = $typeMap->union($this->inferTemplateTypesOnParametersAcceptor($receivedType, $parametersAcceptor));
        }
        return $typeMap;
    }
    private function inferTemplateTypesOnParametersAcceptor(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $receivedType, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor) : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap
    {
        $typeMap = \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        $args = $parametersAcceptor->getParameters();
        $returnType = $parametersAcceptor->getReturnType();
        foreach ($this->getParameters() as $i => $param) {
            $argType = isset($args[$i]) ? $args[$i]->getType() : new \_PhpScoperb75b35f52b74\PHPStan\Type\NeverType();
            $paramType = $param->getType();
            $typeMap = $typeMap->union($paramType->inferTemplateTypes($argType));
        }
        return $typeMap->union($this->getReturnType()->inferTemplateTypes($returnType));
    }
    public function getReferencedTemplateTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $references = $this->getReturnType()->getReferencedTemplateTypes($positionVariance->compose(\_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant()));
        $paramVariance = $positionVariance->compose(\_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance::createContravariant());
        foreach ($this->getParameters() as $param) {
            foreach ($param->getType()->getReferencedTemplateTypes($paramVariance) as $reference) {
                $references[] = $reference;
            }
        }
        return $references;
    }
    public function traverse(callable $cb) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($this->isCommonCallable) {
            return $this;
        }
        $parameters = \array_map(static function (\_PhpScoperb75b35f52b74\PHPStan\Reflection\ParameterReflection $param) use($cb) : NativeParameterReflection {
            $defaultValue = $param->getDefaultValue();
            return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Native\NativeParameterReflection($param->getName(), $param->isOptional(), $cb($param->getType()), $param->passedByReference(), $param->isVariadic(), $defaultValue !== null ? $cb($defaultValue) : null);
        }, $this->getParameters());
        return new self($parameters, $cb($this->getReturnType()), $this->isVariadic());
    }
    public function isArray() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isNumericString() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new self((bool) $properties['isCommonCallable'] ? null : $properties['parameters'], (bool) $properties['isCommonCallable'] ? null : $properties['returnType'], $properties['variadic']);
    }
}
