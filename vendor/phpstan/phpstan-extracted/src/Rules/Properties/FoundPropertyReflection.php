<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Properties;

use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpPropertyReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ResolvedPropertyReflection;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
class FoundPropertyReflection implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection
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
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection $originalPropertyReflection, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, string $propertyName, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $readableType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $writableType)
    {
        $this->originalPropertyReflection = $originalPropertyReflection;
        $this->scope = $scope;
        $this->propertyName = $propertyName;
        $this->readableType = $readableType;
        $this->writableType = $writableType;
    }
    public function getScope() : \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getDeclaringClass() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection
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
    public function getReadableType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->readableType;
    }
    public function getWritableType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
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
    public function isDeprecated() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->originalPropertyReflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->originalPropertyReflection->getDeprecatedDescription();
    }
    public function isInternal() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->originalPropertyReflection->isInternal();
    }
    public function isNative() : bool
    {
        $reflection = $this->originalPropertyReflection;
        if ($reflection instanceof \_PhpScoperb75b35f52b74\PHPStan\Reflection\ResolvedPropertyReflection) {
            $reflection = $reflection->getOriginalReflection();
        }
        return $reflection instanceof \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpPropertyReflection;
    }
    public function getNativeType() : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $reflection = $this->originalPropertyReflection;
        if ($reflection instanceof \_PhpScoperb75b35f52b74\PHPStan\Reflection\ResolvedPropertyReflection) {
            $reflection = $reflection->getOriginalReflection();
        }
        if (!$reflection instanceof \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpPropertyReflection) {
            return null;
        }
        return $reflection->getNativeType();
    }
}
