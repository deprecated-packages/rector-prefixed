<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Annotations;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertyReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
class AnnotationPropertyReflection implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertyReflection
{
    /** @var \PHPStan\Reflection\ClassReflection */
    private $declaringClass;
    /** @var \PHPStan\Type\Type */
    private $type;
    /** @var bool */
    private $readable;
    /** @var bool */
    private $writable;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection $declaringClass, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, bool $readable = \true, bool $writable = \true)
    {
        $this->declaringClass = $declaringClass;
        $this->type = $type;
        $this->readable = $readable;
        $this->writable = $writable;
    }
    public function getDeclaringClass() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection
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
    public function getReadableType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function getWritableType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
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
    public function isDeprecated() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isInternal() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
