<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Properties;

use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\Php\PhpPropertyReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ResolvedPropertyReflection;
use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
class FoundPropertyReflection implements \_PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection
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
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection $originalPropertyReflection, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, string $propertyName, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $readableType, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $writableType)
    {
        $this->originalPropertyReflection = $originalPropertyReflection;
        $this->scope = $scope;
        $this->propertyName = $propertyName;
        $this->readableType = $readableType;
        $this->writableType = $writableType;
    }
    public function getScope() : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getDeclaringClass() : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection
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
    public function getReadableType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->readableType;
    }
    public function getWritableType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
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
    public function isDeprecated() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->originalPropertyReflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->originalPropertyReflection->getDeprecatedDescription();
    }
    public function isInternal() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->originalPropertyReflection->isInternal();
    }
    public function isNative() : bool
    {
        $reflection = $this->originalPropertyReflection;
        if ($reflection instanceof \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ResolvedPropertyReflection) {
            $reflection = $reflection->getOriginalReflection();
        }
        return $reflection instanceof \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Php\PhpPropertyReflection;
    }
    public function getNativeType() : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $reflection = $this->originalPropertyReflection;
        if ($reflection instanceof \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ResolvedPropertyReflection) {
            $reflection = $reflection->getOriginalReflection();
        }
        if (!$reflection instanceof \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Php\PhpPropertyReflection) {
            return null;
        }
        return $reflection->getNativeType();
    }
}
