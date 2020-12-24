<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\Annotations;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
class AnnotationPropertyReflection implements \_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection
{
    /** @var \PHPStan\Reflection\ClassReflection */
    private $declaringClass;
    /** @var \PHPStan\Type\Type */
    private $type;
    /** @var bool */
    private $readable;
    /** @var bool */
    private $writable;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $declaringClass, \_PhpScopere8e811afab72\PHPStan\Type\Type $type, bool $readable = \true, bool $writable = \true)
    {
        $this->declaringClass = $declaringClass;
        $this->type = $type;
        $this->readable = $readable;
        $this->writable = $writable;
    }
    public function getDeclaringClass() : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
    {
        return $this->declaringClass;
    }
    public function isStatic() : bool
    {
        return \false;
    }
    public function isPrivate() : bool
    {
        return \false;
    }
    public function isPublic() : bool
    {
        return \true;
    }
    public function getReadableType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function getWritableType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function canChangeTypeAfterAssignment() : bool
    {
        return \true;
    }
    public function isReadable() : bool
    {
        return $this->readable;
    }
    public function isWritable() : bool
    {
        return $this->writable;
    }
    public function isDeprecated() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isInternal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
