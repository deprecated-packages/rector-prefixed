<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\Php\DummyParameter;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StaticType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeTraverser;
class ObjectTypeMethodReflection implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection
{
    /** @var \PHPStan\Type\ObjectType */
    private $objectType;
    /** @var \PHPStan\Reflection\MethodReflection */
    private $reflection;
    /** @var \PHPStan\Reflection\ParametersAcceptor[]|null */
    private $variants = null;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType $objectType, \_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $reflection)
    {
        $this->objectType = $objectType;
        $this->reflection = $reflection;
    }
    public function getDeclaringClass() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection
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
    public function getPrototype() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberReflection
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
    private function processVariant(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptor $acceptor) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptor
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionVariant($acceptor->getTemplateTypeMap(), $acceptor->getResolvedTemplateTypeMap(), \array_map(function (\_PhpScoperb75b35f52b74\PHPStan\Reflection\ParameterReflection $parameter) : ParameterReflection {
            $type = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeTraverser::map($parameter->getType(), function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, callable $traverse) : Type {
                if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\StaticType) {
                    return $traverse($this->objectType);
                }
                return $traverse($type);
            });
            return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\DummyParameter($parameter->getName(), $type, $parameter->isOptional(), $parameter->passedByReference(), $parameter->isVariadic(), $parameter->getDefaultValue());
        }, $acceptor->getParameters()), $acceptor->isVariadic(), $acceptor->getReturnType());
    }
    public function isDeprecated() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->reflection->getDeprecatedDescription();
    }
    public function isFinal() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->reflection->isFinal();
    }
    public function isInternal() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->reflection->isInternal();
    }
    public function getThrowType() : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->reflection->getThrowType();
    }
    public function hasSideEffects() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->reflection->hasSideEffects();
    }
}
