<?php

declare (strict_types=1);
namespace PHPStan\Reflection\Annotations;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Reflection\MethodReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Type;
class AnnotationMethodReflection implements \PHPStan\Reflection\MethodReflection
{
    /** @var string */
    private $name;
    /** @var \PHPStan\Reflection\ClassReflection */
    private $declaringClass;
    /** @var Type */
    private $returnType;
    /** @var bool */
    private $isStatic;
    /** @var \PHPStan\Reflection\Annotations\AnnotationsMethodParameterReflection[] */
    private $parameters;
    /** @var bool */
    private $isVariadic;
    /** @var FunctionVariant[]|null */
    private $variants = null;
    /**
     * @param string $name
     * @param ClassReflection $declaringClass
     * @param Type $returnType
     * @param \PHPStan\Reflection\Annotations\AnnotationsMethodParameterReflection[] $parameters
     * @param bool $isStatic
     * @param bool $isVariadic
     */
    public function __construct(string $name, \PHPStan\Reflection\ClassReflection $declaringClass, \PHPStan\Type\Type $returnType, array $parameters, bool $isStatic, bool $isVariadic)
    {
        $this->name = $name;
        $this->declaringClass = $declaringClass;
        $this->returnType = $returnType;
        $this->parameters = $parameters;
        $this->isStatic = $isStatic;
        $this->isVariadic = $isVariadic;
    }
    public function getDeclaringClass() : \PHPStan\Reflection\ClassReflection
    {
        return $this->declaringClass;
    }
    public function getPrototype() : \PHPStan\Reflection\ClassMemberReflection
    {
        return $this;
    }
    public function isStatic() : bool
    {
        return $this->isStatic;
    }
    public function isPrivate() : bool
    {
        return \false;
    }
    public function isPublic() : bool
    {
        return \true;
    }
    public function getName() : string
    {
        return $this->name;
    }
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants() : array
    {
        if ($this->variants === null) {
            $this->variants = [new \PHPStan\Reflection\FunctionVariant(\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, $this->parameters, $this->isVariadic, $this->returnType)];
        }
        return $this->variants;
    }
    public function isDeprecated() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isFinal() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isInternal() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getThrowType() : ?\PHPStan\Type\Type
    {
        return null;
    }
    public function hasSideEffects() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
