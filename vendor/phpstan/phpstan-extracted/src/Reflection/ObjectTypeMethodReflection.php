<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

use PHPStan\Reflection\Php\DummyParameter;
use PHPStan\TrinaryLogic;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StaticType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeTraverser;
class ObjectTypeMethodReflection implements \PHPStan\Reflection\MethodReflection
{
    /** @var \PHPStan\Type\ObjectType */
    private $objectType;
    /** @var \PHPStan\Reflection\MethodReflection */
    private $reflection;
    /** @var \PHPStan\Reflection\ParametersAcceptor[]|null */
    private $variants = null;
    public function __construct(\PHPStan\Type\ObjectType $objectType, \PHPStan\Reflection\MethodReflection $reflection)
    {
        $this->objectType = $objectType;
        $this->reflection = $reflection;
    }
    public function getDeclaringClass() : \PHPStan\Reflection\ClassReflection
    {
        return $this->reflection->getDeclaringClass();
    }
    public function isStatic() : bool
    {
        return $this->reflection->isStatic();
    }
    public function isPrivate() : bool
    {
        return $this->reflection->isPrivate();
    }
    public function isPublic() : bool
    {
        return $this->reflection->isPublic();
    }
    public function getDocComment() : ?string
    {
        return $this->reflection->getDocComment();
    }
    public function getName() : string
    {
        return $this->reflection->getName();
    }
    public function getPrototype() : \PHPStan\Reflection\ClassMemberReflection
    {
        return $this->reflection->getPrototype();
    }
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants() : array
    {
        if ($this->variants !== null) {
            return $this->variants;
        }
        $variants = [];
        foreach ($this->reflection->getVariants() as $variant) {
            $variants[] = $this->processVariant($variant);
        }
        $this->variants = $variants;
        return $this->variants;
    }
    private function processVariant(\PHPStan\Reflection\ParametersAcceptor $acceptor) : \PHPStan\Reflection\ParametersAcceptor
    {
        return new \PHPStan\Reflection\FunctionVariant($acceptor->getTemplateTypeMap(), $acceptor->getResolvedTemplateTypeMap(), \array_map(function (\PHPStan\Reflection\ParameterReflection $parameter) : ParameterReflection {
            $type = \PHPStan\Type\TypeTraverser::map($parameter->getType(), function (\PHPStan\Type\Type $type, callable $traverse) : Type {
                if ($type instanceof \PHPStan\Type\StaticType) {
                    return $traverse($this->objectType);
                }
                return $traverse($type);
            });
            return new \PHPStan\Reflection\Php\DummyParameter($parameter->getName(), $type, $parameter->isOptional(), $parameter->passedByReference(), $parameter->isVariadic(), $parameter->getDefaultValue());
        }, $acceptor->getParameters()), $acceptor->isVariadic(), $acceptor->getReturnType());
    }
    public function isDeprecated() : \PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->reflection->getDeprecatedDescription();
    }
    public function isFinal() : \PHPStan\TrinaryLogic
    {
        return $this->reflection->isFinal();
    }
    public function isInternal() : \PHPStan\TrinaryLogic
    {
        return $this->reflection->isInternal();
    }
    public function getThrowType() : ?\PHPStan\Type\Type
    {
        return $this->reflection->getThrowType();
    }
    public function hasSideEffects() : \PHPStan\TrinaryLogic
    {
        return $this->reflection->hasSideEffects();
    }
}
