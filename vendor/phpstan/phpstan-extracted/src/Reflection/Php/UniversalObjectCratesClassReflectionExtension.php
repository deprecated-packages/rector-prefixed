<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\Php;

use _PhpScopere8e811afab72\PHPStan\Broker\Broker;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
class UniversalObjectCratesClassReflectionExtension implements \_PhpScopere8e811afab72\PHPStan\Reflection\PropertiesClassReflectionExtension, \_PhpScopere8e811afab72\PHPStan\Reflection\BrokerAwareExtension
{
    /** @var string[] */
    private $classes;
    /** @var \PHPStan\Broker\Broker */
    private $broker;
    /**
     * @param string[] $classes
     */
    public function __construct(array $classes)
    {
        $this->classes = $classes;
    }
    public function setBroker(\_PhpScopere8e811afab72\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function hasProperty(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        return self::isUniversalObjectCrate($this->broker, $this->classes, $classReflection);
    }
    /**
     * @param \PHPStan\Reflection\ReflectionProvider $reflectionProvider
     * @param string[] $classes
     * @param \PHPStan\Reflection\ClassReflection $classReflection
     * @return bool
     */
    public static function isUniversalObjectCrate(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider, array $classes, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection) : bool
    {
        foreach ($classes as $className) {
            if (!$reflectionProvider->hasClass($className)) {
                continue;
            }
            if ($classReflection->getName() === $className || $classReflection->isSubclassOf($className)) {
                return \true;
            }
        }
        return \false;
    }
    public function getProperty(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection
    {
        if ($classReflection->hasNativeMethod('__get')) {
            $readableType = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('__get')->getVariants())->getReturnType();
        } else {
            $readableType = new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        if ($classReflection->hasNativeMethod('__set')) {
            $writableType = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('__set')->getVariants())->getParameters()[1]->getType();
        } else {
            $writableType = new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        return new \_PhpScopere8e811afab72\PHPStan\Reflection\Php\UniversalObjectCrateProperty($classReflection, $readableType, $writableType);
    }
}
