<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection\Php;

use _PhpScoper0a2ac50786fa\PHPStan\Broker\Broker;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
class UniversalObjectCratesClassReflectionExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertiesClassReflectionExtension, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\BrokerAwareExtension
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
    public function setBroker(\_PhpScoper0a2ac50786fa\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function hasProperty(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        return self::isUniversalObjectCrate($this->broker, $this->classes, $classReflection);
    }
    /**
     * @param \PHPStan\Reflection\ReflectionProvider $reflectionProvider
     * @param string[] $classes
     * @param \PHPStan\Reflection\ClassReflection $classReflection
     * @return bool
     */
    public static function isUniversalObjectCrate(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider $reflectionProvider, array $classes, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $classReflection) : bool
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
    public function getProperty(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection
    {
        if ($classReflection->hasNativeMethod('__get')) {
            $readableType = \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('__get')->getVariants())->getReturnType();
        } else {
            $readableType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
        }
        if ($classReflection->hasNativeMethod('__set')) {
            $writableType = \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('__set')->getVariants())->getParameters()[1]->getType();
        } else {
            $writableType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Php\UniversalObjectCrateProperty($classReflection, $readableType, $writableType);
    }
}
