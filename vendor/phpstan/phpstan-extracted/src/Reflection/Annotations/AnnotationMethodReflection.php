<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\Annotations;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionVariant;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
class AnnotationMethodReflection implements \_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection
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
    public function __construct(string $name, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $declaringClass, \_PhpScopere8e811afab72\PHPStan\Type\Type $returnType, array $parameters, bool $isStatic, bool $isVariadic)
    {
        $this->name = $name;
        $this->declaringClass = $declaringClass;
        $this->returnType = $returnType;
        $this->parameters = $parameters;
        $this->isStatic = $isStatic;
        $this->isVariadic = $isVariadic;
    }
    public function getDeclaringClass() : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
    {
        return $this->declaringClass;
    }
    public function getPrototype() : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberReflection
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
            $this->variants = [new \_PhpScopere8e811afab72\PHPStan\Reflection\FunctionVariant(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, $this->parameters, $this->isVariadic, $this->returnType)];
        }
        return $this->variants;
    }
    public function isDeprecated() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isFinal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function isInternal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function getThrowType() : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return null;
    }
    public function hasSideEffects() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
