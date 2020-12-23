<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection\Php;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\StringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VoidType;
class PhpMethodFromParserNodeReflection extends \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection implements \_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection
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
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $declaringClass, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $realParameterTypes, array $phpDocParameterTypes, array $realParameterDefaultValues, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $realReturnType, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $phpDocReturnType, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $throwType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal)
    {
        $name = \strtolower($classMethod->name->name);
        if ($name === '__construct' || $name === '__destruct' || $name === '__unset' || $name === '__wakeup' || $name === '__clone') {
            $realReturnType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType();
        }
        if ($name === '__tostring') {
            $realReturnType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType();
        }
        if ($name === '__isset') {
            $realReturnType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType();
        }
        if ($name === '__sleep') {
            $realReturnType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType());
        }
        if ($name === '__set_state') {
            $realReturnType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::intersect(new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType(), $realReturnType);
        }
        parent::__construct($classMethod, $templateTypeMap, $realParameterTypes, $phpDocParameterTypes, $realParameterDefaultValues, $realReturnType, $phpDocReturnType, $throwType, $deprecatedDescription, $isDeprecated, $isInternal, $isFinal || $classMethod->isFinal());
        $this->declaringClass = $declaringClass;
    }
    public function getDeclaringClass() : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection
    {
        return $this->declaringClass;
    }
    public function getPrototype() : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberReflection
    {
        try {
            return $this->declaringClass->getNativeMethod($this->getClassMethod()->name->name)->getPrototype();
        } catch (\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MissingMethodFromReflectionException $e) {
            return $this;
        }
    }
    private function getClassMethod() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod
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
