<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Properties;

use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpPropertyReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ResolvedPropertyReflection;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
class FoundPropertyReflection implements \_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection
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
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection $originalPropertyReflection, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope, string $propertyName, \_PhpScopere8e811afab72\PHPStan\Type\Type $readableType, \_PhpScopere8e811afab72\PHPStan\Type\Type $writableType)
    {
        $this->originalPropertyReflection = $originalPropertyReflection;
        $this->scope = $scope;
        $this->propertyName = $propertyName;
        $this->readableType = $readableType;
        $this->writableType = $writableType;
    }
    public function getScope() : \_PhpScopere8e811afab72\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getDeclaringClass() : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
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
    public function getReadableType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->readableType;
    }
    public function getWritableType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
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
    public function isDeprecated() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->originalPropertyReflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->originalPropertyReflection->getDeprecatedDescription();
    }
    public function isInternal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->originalPropertyReflection->isInternal();
    }
    public function isNative() : bool
    {
        $reflection = $this->originalPropertyReflection;
        if ($reflection instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\ResolvedPropertyReflection) {
            $reflection = $reflection->getOriginalReflection();
        }
        return $reflection instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpPropertyReflection;
    }
    public function getNativeType() : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $reflection = $this->originalPropertyReflection;
        if ($reflection instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\ResolvedPropertyReflection) {
            $reflection = $reflection->getOriginalReflection();
        }
        if (!$reflection instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpPropertyReflection) {
            return null;
        }
        return $reflection->getNativeType();
    }
}
