<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\Php;

use RectorPrefix20201227\PHPStan\Broker\Broker;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use RectorPrefix20201227\PHPStan\Reflection\PropertyReflection;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\MixedType;
class UniversalObjectCratesClassReflectionExtension implements \RectorPrefix20201227\PHPStan\Reflection\PropertiesClassReflectionExtension, \RectorPrefix20201227\PHPStan\Reflection\BrokerAwareExtension
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
    public function setBroker(\RectorPrefix20201227\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function hasProperty(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        return self::isUniversalObjectCrate($this->broker, $this->classes, $classReflection);
    }
    /**
     * @param \PHPStan\Reflection\ReflectionProvider $reflectionProvider
     * @param string[] $classes
     * @param \PHPStan\Reflection\ClassReflection $classReflection
     * @return bool
     */
    public static function isUniversalObjectCrate(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $reflectionProvider, array $classes, \RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection) : bool
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
    public function getProperty(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \RectorPrefix20201227\PHPStan\Reflection\PropertyReflection
    {
        if ($classReflection->hasNativeMethod('__get')) {
            $readableType = \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('__get')->getVariants())->getReturnType();
        } else {
            $readableType = new \PHPStan\Type\MixedType();
        }
        if ($classReflection->hasNativeMethod('__set')) {
            $writableType = \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('__set')->getVariants())->getParameters()[1]->getType();
        } else {
            $writableType = new \PHPStan\Type\MixedType();
        }
        return new \RectorPrefix20201227\PHPStan\Reflection\Php\UniversalObjectCrateProperty($classReflection, $readableType, $writableType);
    }
}
