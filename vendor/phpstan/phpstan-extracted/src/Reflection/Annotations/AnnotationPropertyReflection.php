<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection\Annotations;

use _PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\PropertyReflection;
use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
class AnnotationPropertyReflection implements \_PhpScoper0a6b37af0871\PHPStan\Reflection\PropertyReflection
{
    /** @var \PHPStan\Reflection\ClassReflection */
    private $declaringClass;
    /** @var \PHPStan\Type\Type */
    private $type;
    /** @var bool */
    private $readable;
    /** @var bool */
    private $writable;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection $declaringClass, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, bool $readable = \true, bool $writable = \true)
    {
        $this->declaringClass = $declaringClass;
        $this->type = $type;
        $this->readable = $readable;
        $this->writable = $writable;
    }
    public function getDeclaringClass() : \_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection
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
    public function getReadableType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function getWritableType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
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
    public function isDeprecated() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isInternal() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
