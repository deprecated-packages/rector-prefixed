<?php

declare (strict_types=1);
namespace PHPStan\Type;

use RectorPrefix20201227\PHPStan\Broker\Broker;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\Generic\TemplateTypeHelper;
class ThisType extends \PHPStan\Type\StaticType
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
            $classReflection = \RectorPrefix20201227\PHPStan\Broker\Broker::getInstance()->getClass($classReflection);
        }
        parent::__construct($classReflection->getName());
        $this->classReflection = $classReflection;
    }
    public function getStaticObjectType() : \PHPStan\Type\ObjectType
    {
        if ($this->staticObjectType === null) {
            if ($this->classReflection->isGeneric()) {
                $typeMap = $this->classReflection->getTemplateTypeMap()->map(static function (string $name, \PHPStan\Type\Type $type) : Type {
                    return \PHPStan\Type\Generic\TemplateTypeHelper::toArgument($type);
                });
                return $this->staticObjectType = new \PHPStan\Type\Generic\GenericObjectType($this->classReflection->getName(), $this->classReflection->typeMapToList($typeMap));
            }
            return $this->staticObjectType = new \PHPStan\Type\ObjectType($this->classReflection->getName(), null, $this->classReflection);
        }
        return $this->staticObjectType;
    }
    public function changeBaseClass(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection) : \PHPStan\Type\StaticType
    {
        return new self($classReflection);
    }
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('$this(%s)', $this->getClassName());
    }
}
