<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\Annotations;

use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\PropertyReflection;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
class AnnotationPropertyReflection implements \RectorPrefix20201227\PHPStan\Reflection\PropertyReflection
{
    /** @var \PHPStan\Reflection\ClassReflection */
    private $declaringClass;
    /** @var \PHPStan\Type\Type */
    private $type;
    /** @var bool */
    private $readable;
    /** @var bool */
    private $writable;
    public function __construct(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $declaringClass, \PHPStan\Type\Type $type, bool $readable = \true, bool $writable = \true)
    {
        $this->declaringClass = $declaringClass;
        $this->type = $type;
        $this->readable = $readable;
        $this->writable = $writable;
    }
    public function getDeclaringClass() : \RectorPrefix20201227\PHPStan\Reflection\ClassReflection
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
    public function getReadableType() : \PHPStan\Type\Type
    {
        return $this->type;
    }
    public function getWritableType() : \PHPStan\Type\Type
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
    public function isDeprecated() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isInternal() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
