<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

use _PhpScopera143bcca66cb\NativeStaticReturnType\Foo;
use PHPStan\Testing\TestCase;
use PHPStan\Type\StaticType;
class StaticTypeTest extends \PHPStan\Testing\TestCase
{
    public function testMixedType() : void
    {
        if (\PHP_VERSION_ID < 80000 && !self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires PHP 8.0');
        }
        $reflectionProvider = $this->createBroker();
        $class = $reflectionProvider->getClass(\_PhpScopera143bcca66cb\NativeStaticReturnType\Foo::class);
        $method = $class->getNativeMethod('doFoo');
        $methodVariant = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants());
        $methodReturnType = $methodVariant->getReturnType();
        $this->assertInstanceOf(\PHPStan\Type\StaticType::class, $methodReturnType);
        $this->assertSame(\_PhpScopera143bcca66cb\NativeStaticReturnType\Foo::class, $methodReturnType->getClassName());
    }
}
