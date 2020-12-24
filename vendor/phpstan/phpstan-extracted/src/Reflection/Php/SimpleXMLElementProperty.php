<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\Php;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\FloatType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
class SimpleXMLElementProperty implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection
{
    /** @var \PHPStan\Reflection\ClassReflection */
    private $declaringClass;
    /** @var \PHPStan\Type\Type */
    private $type;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $declaringClass, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $type)
    {
        $this->declaringClass = $declaringClass;
        $this->type = $type;
    }
    public function getDeclaringClass() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection
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
    public function getReadableType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function getWritableType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union($this->type, new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType());
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
    public function isDeprecated() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isInternal() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
