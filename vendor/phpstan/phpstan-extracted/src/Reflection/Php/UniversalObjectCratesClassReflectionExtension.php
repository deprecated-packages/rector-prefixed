<?php

declare (strict_types=1);
namespace PHPStan\Reflection\Php;

use PHPStan\Broker\Broker;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\MixedType;
class UniversalObjectCratesClassReflectionExtension implements \PHPStan\Reflection\PropertiesClassReflectionExtension, \PHPStan\Reflection\BrokerAwareExtension
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
    public function setBroker(\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function hasProperty(\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        return self::isUniversalObjectCrate($this->broker, $this->classes, $classReflection);
    }
    /**
     * @param \PHPStan\Reflection\ReflectionProvider $reflectionProvider
     * @param string[] $classes
     * @param \PHPStan\Reflection\ClassReflection $classReflection
     * @return bool
     */
    public static function isUniversalObjectCrate(\PHPStan\Reflection\ReflectionProvider $reflectionProvider, array $classes, \PHPStan\Reflection\ClassReflection $classReflection) : bool
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
    public function getProperty(\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \PHPStan\Reflection\PropertyReflection
    {
        if ($classReflection->hasNativeMethod('__get')) {
            $readableType = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('__get')->getVariants())->getReturnType();
        } else {
            $readableType = new \PHPStan\Type\MixedType();
        }
        if ($classReflection->hasNativeMethod('__set')) {
            $writableType = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('__set')->getVariants())->getParameters()[1]->getType();
        } else {
            $writableType = new \PHPStan\Type\MixedType();
        }
        return new \PHPStan\Reflection\Php\UniversalObjectCrateProperty($classReflection, $readableType, $writableType);
    }
}
