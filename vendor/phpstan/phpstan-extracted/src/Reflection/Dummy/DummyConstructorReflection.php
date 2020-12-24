<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection\Dummy;

use _PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionVariant;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\VoidType;
class DummyConstructorReflection implements \_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection
{
    /** @var ClassReflection */
    private $declaringClass;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection $declaringClass)
    {
        $this->declaringClass = $declaringClass;
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
    public function getName() : string
    {
        return '__construct';
    }
    public function getPrototype() : \_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberReflection
    {
        return $this;
    }
    public function getVariants() : array
    {
        return [new \_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionVariant(\_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, [], \false, new \_PhpScoper0a6b37af0871\PHPStan\Type\VoidType())];
    }
    public function isDeprecated() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isFinal() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isInternal() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getThrowType() : ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return null;
    }
    public function hasSideEffects() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
