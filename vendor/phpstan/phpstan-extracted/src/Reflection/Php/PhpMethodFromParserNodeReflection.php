<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
use _PhpScopere8e811afab72\PHPStan\Type\VoidType;
class PhpMethodFromParserNodeReflection extends \_PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection implements \_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection
{
    /** @var \PHPStan\Reflection\ClassReflection */
    private $declaringClass;
    /**
     * @param ClassReflection $declaringClass
     * @param ClassMethod $classMethod
     * @param TemplateTypeMap $templateTypeMap
     * @param \PHPStan\Type\Type[] $realParameterTypes
     * @param \PHPStan\Type\Type[] $phpDocParameterTypes
     * @param \PHPStan\Type\Type[] $realParameterDefaultValues
     * @param Type $realReturnType
     * @param Type|null $phpDocReturnType
     * @param Type|null $throwType
     * @param string|null $deprecatedDescription
     * @param bool $isDeprecated
     * @param bool $isInternal
     * @param bool $isFinal
     */
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $declaringClass, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $realParameterTypes, array $phpDocParameterTypes, array $realParameterDefaultValues, \_PhpScopere8e811afab72\PHPStan\Type\Type $realReturnType, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $phpDocReturnType, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $throwType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal)
    {
        $name = \strtolower($classMethod->name->name);
        if ($name === '__construct' || $name === '__destruct' || $name === '__unset' || $name === '__wakeup' || $name === '__clone') {
            $realReturnType = new \_PhpScopere8e811afab72\PHPStan\Type\VoidType();
        }
        if ($name === '__tostring') {
            $realReturnType = new \_PhpScopere8e811afab72\PHPStan\Type\StringType();
        }
        if ($name === '__isset') {
            $realReturnType = new \_PhpScopere8e811afab72\PHPStan\Type\BooleanType();
        }
        if ($name === '__sleep') {
            $realReturnType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\StringType());
        }
        if ($name === '__set_state') {
            $realReturnType = \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::intersect(new \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType(), $realReturnType);
        }
        parent::__construct($classMethod, $templateTypeMap, $realParameterTypes, $phpDocParameterTypes, $realParameterDefaultValues, $realReturnType, $phpDocReturnType, $throwType, $deprecatedDescription, $isDeprecated, $isInternal, $isFinal || $classMethod->isFinal());
        $this->declaringClass = $declaringClass;
    }
    public function getDeclaringClass() : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
    {
        return $this->declaringClass;
    }
    public function getPrototype() : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberReflection
    {
        try {
            return $this->declaringClass->getNativeMethod($this->getClassMethod()->name->name)->getPrototype();
        } catch (\_PhpScopere8e811afab72\PHPStan\Reflection\MissingMethodFromReflectionException $e) {
            return $this;
        }
    }
    private function getClassMethod() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        /** @var \PhpParser\Node\Stmt\ClassMethod $functionLike */
        $functionLike = $this->getFunctionLike();
        return $functionLike;
    }
    public function isStatic() : bool
    {
        return $this->getClassMethod()->isStatic();
    }
    public function isPrivate() : bool
    {
        return $this->getClassMethod()->isPrivate();
    }
    public function isPublic() : bool
    {
        return $this->getClassMethod()->isPublic();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
    public function isBuiltin() : bool
    {
        return \false;
    }
}
