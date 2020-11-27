<?php

declare (strict_types=1);
namespace PHPStan\Rules\Properties;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\Php\PhpPropertyReflection;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\Reflection\ResolvedPropertyReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
class FoundPropertyReflection implements \PHPStan\Reflection\PropertyReflection
{
    /**
     * @var \PHPStan\Reflection\PropertyReflection
     */
    private $originalPropertyReflection;
    /**
     * @var \PHPStan\Type\Type
     */
    private $readableType;
    /**
     * @var \PHPStan\Type\Type
     */
    private $writableType;
    public function __construct(\PHPStan\Reflection\PropertyReflection $originalPropertyReflection, \PHPStan\Type\Type $readableType, \PHPStan\Type\Type $writableType)
    {
        $this->originalPropertyReflection = $originalPropertyReflection;
        $this->readableType = $readableType;
        $this->writableType = $writableType;
    }
    public function getDeclaringClass() : \PHPStan\Reflection\ClassReflection
    {
        return $this->originalPropertyReflection->getDeclaringClass();
    }
    public function isStatic() : bool
    {
        return $this->originalPropertyReflection->isStatic();
    }
    public function isPrivate() : bool
    {
        return $this->originalPropertyReflection->isPrivate();
    }
    public function isPublic() : bool
    {
        return $this->originalPropertyReflection->isPublic();
    }
    public function getDocComment() : ?string
    {
        return $this->originalPropertyReflection->getDocComment();
    }
    public function getReadableType() : \PHPStan\Type\Type
    {
        return $this->readableType;
    }
    public function getWritableType() : \PHPStan\Type\Type
    {
        return $this->writableType;
    }
    public function canChangeTypeAfterAssignment() : bool
    {
        return $this->originalPropertyReflection->canChangeTypeAfterAssignment();
    }
    public function isReadable() : bool
    {
        return $this->originalPropertyReflection->isReadable();
    }
    public function isWritable() : bool
    {
        return $this->originalPropertyReflection->isWritable();
    }
    public function isDeprecated() : \PHPStan\TrinaryLogic
    {
        return $this->originalPropertyReflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->originalPropertyReflection->getDeprecatedDescription();
    }
    public function isInternal() : \PHPStan\TrinaryLogic
    {
        return $this->originalPropertyReflection->isInternal();
    }
    public function isNative() : bool
    {
        $reflection = $this->originalPropertyReflection;
        if ($reflection instanceof \PHPStan\Reflection\ResolvedPropertyReflection) {
            $reflection = $reflection->getOriginalReflection();
        }
        return $reflection instanceof \PHPStan\Reflection\Php\PhpPropertyReflection;
    }
    public function getNativeType() : ?\PHPStan\Type\Type
    {
        $reflection = $this->originalPropertyReflection;
        if ($reflection instanceof \PHPStan\Reflection\ResolvedPropertyReflection) {
            $reflection = $reflection->getOriginalReflection();
        }
        if (!$reflection instanceof \PHPStan\Reflection\Php\PhpPropertyReflection) {
            return null;
        }
        return $reflection->getNativeType();
    }
}
