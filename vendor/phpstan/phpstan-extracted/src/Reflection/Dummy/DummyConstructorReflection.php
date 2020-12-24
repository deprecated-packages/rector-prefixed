<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\Dummy;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionVariant;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\VoidType;
class DummyConstructorReflection implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection
{
    /** @var ClassReflection */
    private $declaringClass;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $declaringClass)
    {
        $this->declaringClass = $declaringClass;
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
    public function getName() : string
    {
        return '__construct';
    }
    public function getPrototype() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberReflection
    {
        return $this;
    }
    public function getVariants() : array
    {
        return [new \_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionVariant(\_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, [], \false, new \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType())];
    }
    public function isDeprecated() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isFinal() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isInternal() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getThrowType() : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return null;
    }
    public function hasSideEffects() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
