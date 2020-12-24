<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\Php;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypehintHelper;
class PhpPropertyReflection implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection
{
    /** @var \PHPStan\Reflection\ClassReflection */
    private $declaringClass;
    /** @var \PHPStan\Reflection\ClassReflection|null */
    private $declaringTrait;
    /** @var \ReflectionType|null */
    private $nativeType;
    /** @var \PHPStan\Type\Type|null */
    private $finalNativeType = null;
    /** @var \PHPStan\Type\Type|null */
    private $phpDocType;
    /** @var \PHPStan\Type\Type|null */
    private $type = null;
    /** @var \ReflectionProperty */
    private $reflection;
    /** @var string|null */
    private $deprecatedDescription;
    /** @var bool */
    private $isDeprecated;
    /** @var bool */
    private $isInternal;
    /** @var string|null */
    private $stubPhpDocString;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $declaringClass, ?\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $declaringTrait, ?\ReflectionType $nativeType, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $phpDocType, \ReflectionProperty $reflection, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, ?string $stubPhpDocString)
    {
        $this->declaringClass = $declaringClass;
        $this->declaringTrait = $declaringTrait;
        $this->nativeType = $nativeType;
        $this->phpDocType = $phpDocType;
        $this->reflection = $reflection;
        $this->deprecatedDescription = $deprecatedDescription;
        $this->isDeprecated = $isDeprecated;
        $this->isInternal = $isInternal;
        $this->stubPhpDocString = $stubPhpDocString;
    }
    public function getDeclaringClass() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection
    {
        return $this->declaringClass;
    }
    public function getDeclaringTrait() : ?\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection
    {
        return $this->declaringTrait;
    }
    public function getDocComment() : ?string
    {
        if ($this->stubPhpDocString !== null) {
            return $this->stubPhpDocString;
        }
        $docComment = $this->reflection->getDocComment();
        if ($docComment === \false) {
            return null;
        }
        return $docComment;
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
    public function getReadableType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($this->type === null) {
            $this->type = \_PhpScoperb75b35f52b74\PHPStan\Type\TypehintHelper::decideTypeFromReflection($this->nativeType, $this->phpDocType, $this->declaringClass->getName());
        }
        return $this->type;
    }
    public function getWritableType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->getReadableType();
    }
    public function canChangeTypeAfterAssignment() : bool
    {
        return \true;
    }
    public function isPromoted() : bool
    {
        if (!\method_exists($this->reflection, 'isPromoted')) {
            return \false;
        }
        return $this->reflection->isPromoted();
    }
    public function hasPhpDoc() : bool
    {
        return $this->phpDocType !== null;
    }
    public function getPhpDocType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($this->phpDocType !== null) {
            return $this->phpDocType;
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
    }
    public function getNativeType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($this->finalNativeType === null) {
            $this->finalNativeType = \_PhpScoperb75b35f52b74\PHPStan\Type\TypehintHelper::decideTypeFromReflection($this->nativeType, null, $this->declaringClass->getName());
        }
        return $this->finalNativeType;
    }
    public function isReadable() : bool
    {
        return \true;
    }
    public function isWritable() : bool
    {
        return \true;
    }
    public function getDeprecatedDescription() : ?string
    {
        if ($this->isDeprecated) {
            return $this->deprecatedDescription;
        }
        return null;
    }
    public function isDeprecated() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createFromBoolean($this->isDeprecated);
    }
    public function isInternal() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createFromBoolean($this->isInternal);
    }
}
