<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
use _PhpScoperb75b35f52b74\PHPStan\Type\VoidType;
class PhpMethodFromParserNodeReflection extends \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection
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
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $declaringClass, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $realParameterTypes, array $phpDocParameterTypes, array $realParameterDefaultValues, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $realReturnType, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $phpDocReturnType, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $throwType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal)
    {
        $name = \strtolower($classMethod->name->name);
        if ($name === '__construct' || $name === '__destruct' || $name === '__unset' || $name === '__wakeup' || $name === '__clone') {
            $realReturnType = new \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType();
        }
        if ($name === '__tostring') {
            $realReturnType = new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType();
        }
        if ($name === '__isset') {
            $realReturnType = new \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType();
        }
        if ($name === '__sleep') {
            $realReturnType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType());
        }
        if ($name === '__set_state') {
            $realReturnType = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::intersect(new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType(), $realReturnType);
        }
        parent::__construct($classMethod, $templateTypeMap, $realParameterTypes, $phpDocParameterTypes, $realParameterDefaultValues, $realReturnType, $phpDocReturnType, $throwType, $deprecatedDescription, $isDeprecated, $isInternal, $isFinal || $classMethod->isFinal());
        $this->declaringClass = $declaringClass;
    }
    public function getDeclaringClass() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection
    {
        return $this->declaringClass;
    }
    public function getPrototype() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberReflection
    {
        try {
            return $this->declaringClass->getNativeMethod($this->getClassMethod()->name->name)->getPrototype();
        } catch (\_PhpScoperb75b35f52b74\PHPStan\Reflection\MissingMethodFromReflectionException $e) {
            return $this;
        }
    }
    private function getClassMethod() : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
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
