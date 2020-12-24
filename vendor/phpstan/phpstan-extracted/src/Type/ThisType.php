<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\Broker\Broker;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeHelper;
class ThisType extends \_PhpScopere8e811afab72\PHPStan\Type\StaticType
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
            $classReflection = \_PhpScopere8e811afab72\PHPStan\Broker\Broker::getInstance()->getClass($classReflection);
        }
        parent::__construct($classReflection->getName());
        $this->classReflection = $classReflection;
    }
    public function getStaticObjectType() : \_PhpScopere8e811afab72\PHPStan\Type\ObjectType
    {
        if ($this->staticObjectType === null) {
            if ($this->classReflection->isGeneric()) {
                $typeMap = $this->classReflection->getTemplateTypeMap()->map(static function (string $name, \_PhpScopere8e811afab72\PHPStan\Type\Type $type) : Type {
                    return \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeHelper::toArgument($type);
                });
                return $this->staticObjectType = new \_PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType($this->classReflection->getName(), $this->classReflection->typeMapToList($typeMap));
            }
            return $this->staticObjectType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($this->classReflection->getName(), null, $this->classReflection);
        }
        return $this->staticObjectType;
    }
    public function changeBaseClass(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection) : \_PhpScopere8e811afab72\PHPStan\Type\StaticType
    {
        return new self($classReflection);
    }
    public function describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('$this(%s)', $this->getClassName());
    }
}
