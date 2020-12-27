<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection;

use RectorPrefix20201227\PHPStan\Reflection\Php\PhpMethodReflection;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Type;
class ResolvedMethodReflection implements \RectorPrefix20201227\PHPStan\Reflection\MethodReflection
{
    /** @var MethodReflection */
    private $reflection;
    /** @var TemplateTypeMap */
    private $resolvedTemplateTypeMap;
    /** @var \PHPStan\Reflection\ParametersAcceptor[]|null */
    private $variants = null;
    public function __construct(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $reflection, \PHPStan\Type\Generic\TemplateTypeMap $resolvedTemplateTypeMap)
    {
        $this->reflection = $reflection;
        $this->resolvedTemplateTypeMap = $resolvedTemplateTypeMap;
    }
    public function getName() : string
    {
        return $this->reflection->getName();
    }
    public function getPrototype() : \RectorPrefix20201227\PHPStan\Reflection\ClassMemberReflection
    {
        return $this->reflection->getPrototype();
    }
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants() : array
    {
        $variants = $this->variants;
        if ($variants !== null) {
            return $variants;
        }
        $variants = [];
        foreach ($this->reflection->getVariants() as $variant) {
            $variants[] = new \RectorPrefix20201227\PHPStan\Reflection\ResolvedFunctionVariant($variant, $this->resolvedTemplateTypeMap);
        }
        $this->variants = $variants;
        return $variants;
    }
    public function getDeclaringClass() : \RectorPrefix20201227\PHPStan\Reflection\ClassReflection
    {
        return $this->reflection->getDeclaringClass();
    }
    public function getDeclaringTrait() : ?\RectorPrefix20201227\PHPStan\Reflection\ClassReflection
    {
        if ($this->reflection instanceof \RectorPrefix20201227\PHPStan\Reflection\Php\PhpMethodReflection) {
            return $this->reflection->getDeclaringTrait();
        }
        return null;
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
    public function isDeprecated() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->reflection->getDeprecatedDescription();
    }
    public function isFinal() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->reflection->isFinal();
    }
    public function isInternal() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->reflection->isInternal();
    }
    public function getThrowType() : ?\PHPStan\Type\Type
    {
        return $this->reflection->getThrowType();
    }
    public function hasSideEffects() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->reflection->hasSideEffects();
    }
}
