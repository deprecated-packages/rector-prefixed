<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Properties;

use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\Php\PhpPropertyReflection;
use RectorPrefix20201227\PHPStan\Reflection\PropertyReflection;
use RectorPrefix20201227\PHPStan\Reflection\ResolvedPropertyReflection;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
class FoundPropertyReflection implements \RectorPrefix20201227\PHPStan\Reflection\PropertyReflection
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
    public function __construct(\RectorPrefix20201227\PHPStan\Reflection\PropertyReflection $originalPropertyReflection, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope, string $propertyName, \PHPStan\Type\Type $readableType, \PHPStan\Type\Type $writableType)
    {
        $this->originalPropertyReflection = $originalPropertyReflection;
        $this->scope = $scope;
        $this->propertyName = $propertyName;
        $this->readableType = $readableType;
        $this->writableType = $writableType;
    }
    public function getScope() : \RectorPrefix20201227\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getDeclaringClass() : \RectorPrefix20201227\PHPStan\Reflection\ClassReflection
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
    public function isDeprecated() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->originalPropertyReflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->originalPropertyReflection->getDeprecatedDescription();
    }
    public function isInternal() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->originalPropertyReflection->isInternal();
    }
    public function isNative() : bool
    {
        $reflection = $this->originalPropertyReflection;
        if ($reflection instanceof \RectorPrefix20201227\PHPStan\Reflection\ResolvedPropertyReflection) {
            $reflection = $reflection->getOriginalReflection();
        }
        return $reflection instanceof \RectorPrefix20201227\PHPStan\Reflection\Php\PhpPropertyReflection;
    }
    public function getNativeType() : ?\PHPStan\Type\Type
    {
        $reflection = $this->originalPropertyReflection;
        if ($reflection instanceof \RectorPrefix20201227\PHPStan\Reflection\ResolvedPropertyReflection) {
            $reflection = $reflection->getOriginalReflection();
        }
        if (!$reflection instanceof \RectorPrefix20201227\PHPStan\Reflection\Php\PhpPropertyReflection) {
            return null;
        }
        return $reflection->getNativeType();
    }
}
