<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Php\DummyParameter;
use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StaticType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeTraverser;
class ObjectTypeMethodReflection implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection
{
    /** @var \PHPStan\Type\ObjectType */
    private $objectType;
    /** @var \PHPStan\Reflection\MethodReflection */
    private $reflection;
    /** @var \PHPStan\Reflection\ParametersAcceptor[]|null */
    private $variants = null;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType $objectType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection $reflection)
    {
        $this->objectType = $objectType;
        $this->reflection = $reflection;
    }
    public function getDeclaringClass() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection
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
    public function getPrototype() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberReflection
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
    private function processVariant(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptor $acceptor) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptor
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionVariant($acceptor->getTemplateTypeMap(), $acceptor->getResolvedTemplateTypeMap(), \array_map(function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParameterReflection $parameter) : ParameterReflection {
            $type = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeTraverser::map($parameter->getType(), function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, callable $traverse) : Type {
                if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StaticType) {
                    return $traverse($this->objectType);
                }
                return $traverse($type);
            });
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Php\DummyParameter($parameter->getName(), $type, $parameter->isOptional(), $parameter->passedByReference(), $parameter->isVariadic(), $parameter->getDefaultValue());
        }, $acceptor->getParameters()), $acceptor->isVariadic(), $acceptor->getReturnType());
    }
    public function isDeprecated() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->reflection->getDeprecatedDescription();
    }
    public function isFinal() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return $this->reflection->isFinal();
    }
    public function isInternal() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return $this->reflection->isInternal();
    }
    public function getThrowType() : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->reflection->getThrowType();
    }
    public function hasSideEffects() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return $this->reflection->hasSideEffects();
    }
}
