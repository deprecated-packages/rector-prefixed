<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type;

use _PhpScoper0a6b37af0871\PHPStan\Broker\Broker;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeHelper;
class ThisType extends \_PhpScoper0a6b37af0871\PHPStan\Type\StaticType
{
    /** @var ClassReflection */
    private $classReflection;
    /** @var \PHPStan\Type\ObjectType|null */
    private $staticObjectType = null;
    /**
     * @param string|ClassReflection $classReflection
     */
    public function __construct($classReflection)
    {
        if (\is_string($classReflection)) {
            $classReflection = \_PhpScoper0a6b37af0871\PHPStan\Broker\Broker::getInstance()->getClass($classReflection);
        }
        parent::__construct($classReflection->getName());
        $this->classReflection = $classReflection;
    }
    public function getStaticObjectType() : \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType
    {
        if ($this->staticObjectType === null) {
            if ($this->classReflection->isGeneric()) {
                $typeMap = $this->classReflection->getTemplateTypeMap()->map(static function (string $name, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : Type {
                    return \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeHelper::toArgument($type);
                });
                return $this->staticObjectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericObjectType($this->classReflection->getName(), $this->classReflection->typeMapToList($typeMap));
            }
            return $this->staticObjectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($this->classReflection->getName(), null, $this->classReflection);
        }
        return $this->staticObjectType;
    }
    public function changeBaseClass(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection $classReflection) : \_PhpScoper0a6b37af0871\PHPStan\Type\StaticType
    {
        return new self($classReflection);
    }
    public function describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('$this(%s)', $this->getClassName());
    }
}
