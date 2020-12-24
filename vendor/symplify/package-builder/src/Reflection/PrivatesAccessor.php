<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection;

use ReflectionProperty;
use _PhpScopere8e811afab72\Symplify\PHPStanRules\Exception\ShouldNotHappenException;
/**
 * @see \Symplify\PackageBuilder\Tests\Reflection\PrivatesAccessorTest
 */
final class PrivatesAccessor
{
    public function getPrivateProperty(object $object, string $propertyName)
    {
        if (\property_exists($object, $propertyName)) {
            $propertyReflection = new \ReflectionProperty($object, $propertyName);
        } else {
            $parentClass = \get_parent_class($object);
            if ($parentClass === \false) {
                throw new \_PhpScopere8e811afab72\Symplify\PHPStanRules\Exception\ShouldNotHappenException();
            }
            $propertyReflection = new \ReflectionProperty($parentClass, $propertyName);
        }
        $propertyReflection->setAccessible(\true);
        return $propertyReflection->getValue($object);
    }
    public function setPrivateProperty(object $object, string $propertyName, $value) : void
    {
        $propertyReflection = new \ReflectionProperty(\get_class($object), $propertyName);
        $propertyReflection->setAccessible(\true);
        $propertyReflection->setValue($object, $value);
    }
}
