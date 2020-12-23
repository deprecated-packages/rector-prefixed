<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection;

use _PhpScoper0a2ac50786fa\PHPStan\Reflection\Php\DummyParameter;
use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\StaticType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeTraverser;
class ObjectTypeMethodReflection implements \_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection
{
    /** @var \PHPStan\Type\ObjectType */
    private $objectType;
    /** @var \PHPStan\Reflection\MethodReflection */
    private $reflection;
    /** @var \PHPStan\Reflection\ParametersAcceptor[]|null */
    private $variants = null;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType $objectType, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $reflection)
    {
        $this->objectType = $objectType;
        $this->reflection = $reflection;
    }
    public function getDeclaringClass() : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection
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
    public function getPrototype() : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberReflection
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
    private function processVariant(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptor $acceptor) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptor
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionVariant($acceptor->getTemplateTypeMap(), $acceptor->getResolvedTemplateTypeMap(), \array_map(function (\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParameterReflection $parameter) : ParameterReflection {
            $type = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeTraverser::map($parameter->getType(), function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, callable $traverse) : Type {
                if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\StaticType) {
                    return $traverse($this->objectType);
                }
                return $traverse($type);
            });
            return new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Php\DummyParameter($parameter->getName(), $type, $parameter->isOptional(), $parameter->passedByReference(), $parameter->isVariadic(), $parameter->getDefaultValue());
        }, $acceptor->getParameters()), $acceptor->isVariadic(), $acceptor->getReturnType());
    }
    public function isDeprecated() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->reflection->getDeprecatedDescription();
    }
    public function isFinal() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->reflection->isFinal();
    }
    public function isInternal() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->reflection->isInternal();
    }
    public function getThrowType() : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->reflection->getThrowType();
    }
    public function hasSideEffects() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->reflection->hasSideEffects();
    }
}
