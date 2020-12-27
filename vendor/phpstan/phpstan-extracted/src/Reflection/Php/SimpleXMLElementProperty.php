<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\Php;

use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\PropertyReflection;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\BooleanType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
class SimpleXMLElementProperty implements \RectorPrefix20201227\PHPStan\Reflection\PropertyReflection
{
    /** @var \PHPStan\Reflection\ClassReflection */
    private $declaringClass;
    /** @var \PHPStan\Type\Type */
    private $type;
    public function __construct(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $declaringClass, \PHPStan\Type\Type $type)
    {
        $this->declaringClass = $declaringClass;
        $this->type = $type;
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
        return \PHPStan\Type\TypeCombinator::union($this->type, new \PHPStan\Type\IntegerType(), new \PHPStan\Type\FloatType(), new \PHPStan\Type\StringType(), new \PHPStan\Type\BooleanType());
    }
    public function isReadable() : bool
    {
        return \true;
    }
    public function isWritable() : bool
    {
        return \true;
    }
    public function canChangeTypeAfterAssignment() : bool
    {
        return \false;
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
