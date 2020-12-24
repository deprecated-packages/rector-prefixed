<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\Php;

use _PhpScoperb75b35f52b74\PHPStan\Broker\Broker;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
class UniversalObjectCratesClassReflectionExtension implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertiesClassReflectionExtension, \_PhpScoperb75b35f52b74\PHPStan\Reflection\BrokerAwareExtension
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
    public function setBroker(\_PhpScoperb75b35f52b74\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function hasProperty(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        return self::isUniversalObjectCrate($this->broker, $this->classes, $classReflection);
    }
    /**
     * @param \PHPStan\Reflection\ReflectionProvider $reflectionProvider
     * @param string[] $classes
     * @param \PHPStan\Reflection\ClassReflection $classReflection
     * @return bool
     */
    public static function isUniversalObjectCrate(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $reflectionProvider, array $classes, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection) : bool
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
    public function getProperty(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection
    {
        if ($classReflection->hasNativeMethod('__get')) {
            $readableType = \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('__get')->getVariants())->getReturnType();
        } else {
            $readableType = new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        if ($classReflection->hasNativeMethod('__set')) {
            $writableType = \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('__set')->getVariants())->getParameters()[1]->getType();
        } else {
            $writableType = new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\UniversalObjectCrateProperty($classReflection, $readableType, $writableType);
    }
}
