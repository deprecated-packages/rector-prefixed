<?php

declare (strict_types=1);
namespace PHPStan\Reflection\Php;

use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\IntegerType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\VoidType;
class PhpMethodFromParserNodeReflection extends \PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection implements \PHPStan\Reflection\MethodReflection
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
    public function __construct(\PHPStan\Reflection\ClassReflection $declaringClass, \PhpParser\Node\Stmt\ClassMethod $classMethod, \PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $realParameterTypes, array $phpDocParameterTypes, array $realParameterDefaultValues, \PHPStan\Type\Type $realReturnType, ?\PHPStan\Type\Type $phpDocReturnType, ?\PHPStan\Type\Type $throwType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal)
    {
        $name = \strtolower($classMethod->name->name);
        if ($name === '__construct' || $name === '__destruct' || $name === '__unset' || $name === '__wakeup' || $name === '__clone') {
            $realReturnType = new \PHPStan\Type\VoidType();
        }
        if ($name === '__tostring') {
            $realReturnType = new \PHPStan\Type\StringType();
        }
        if ($name === '__isset') {
            $realReturnType = new \PHPStan\Type\BooleanType();
        }
        if ($name === '__sleep') {
            $realReturnType = new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType());
        }
        if ($name === '__set_state') {
            $realReturnType = \PHPStan\Type\TypeCombinator::intersect(new \PHPStan\Type\ObjectWithoutClassType(), $realReturnType);
        }
        parent::__construct($classMethod, $templateTypeMap, $realParameterTypes, $phpDocParameterTypes, $realParameterDefaultValues, $realReturnType, $phpDocReturnType, $throwType, $deprecatedDescription, $isDeprecated, $isInternal, $isFinal || $classMethod->isFinal());
        $this->declaringClass = $declaringClass;
    }
    public function getDeclaringClass() : \PHPStan\Reflection\ClassReflection
    {
        return $this->declaringClass;
    }
    public function getPrototype() : \PHPStan\Reflection\ClassMemberReflection
    {
        try {
            return $this->declaringClass->getNativeMethod($this->getClassMethod()->name->name)->getPrototype();
        } catch (\PHPStan\Reflection\MissingMethodFromReflectionException $e) {
            return $this;
        }
    }
    private function getClassMethod() : \PhpParser\Node\Stmt\ClassMethod
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
