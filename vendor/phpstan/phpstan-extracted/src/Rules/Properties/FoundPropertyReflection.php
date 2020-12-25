<?php

declare (strict_types=1);
namespace PHPStan\Rules\Properties;

use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\Php\PhpPropertyReflection;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\Reflection\ResolvedPropertyReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
class FoundPropertyReflection implements \PHPStan\Reflection\PropertyReflection
{
    /** @var PropertyReflection */
    private $originalPropertyReflection;
    /** @var Scope */
    private $scope;
    /** @var string */
    private $propertyName;
    /** @var Type */
    private $readableType;
    /** @var Type */
    private $writableType;
    public function __construct(\PHPStan\Reflection\PropertyReflection $originalPropertyReflection, \PHPStan\Analyser\Scope $scope, string $propertyName, \PHPStan\Type\Type $readableType, \PHPStan\Type\Type $writableType)
    {
        $this->originalPropertyReflection = $originalPropertyReflection;
        $this->scope = $scope;
        $this->propertyName = $propertyName;
        $this->readableType = $readableType;
        $this->writableType = $writableType;
    }
    public function getScope() : \PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getDeclaringClass() : \PHPStan\Reflection\ClassReflection
    {
        return $this->originalPropertyReflection->getDeclaringClass();
    }
    public function getName() : string
    {
        return $this->propertyName;
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
