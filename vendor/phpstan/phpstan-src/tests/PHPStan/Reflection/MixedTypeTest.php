<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

use _PhpScoperabd03f0baf05\NativeMixedType\Foo;
use PhpParser\Node\Name;
use PHPStan\Testing\TestCase;
use PHPStan\Type\MixedType;
class MixedTypeTest extends \PHPStan\Testing\TestCase
{
    public function testMixedType() : void
    {
        if (\PHP_VERSION_ID < 80000 && !self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires PHP 8.0');
        }
        $reflectionProvider = $this->createBroker();
        $class = $reflectionProvider->getClass(\_PhpScoperabd03f0baf05\NativeMixedType\Foo::class);
        $propertyType = $class->getNativeProperty('fooProp')->getNativeType();
        $this->assertInstanceOf(\PHPStan\Type\MixedType::class, $propertyType);
        $this->assertTrue($propertyType->isExplicitMixed());
        $method = $class->getNativeMethod('doFoo');
        $methodVariant = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants());
        $methodReturnType = $methodVariant->getReturnType();
        $this->assertInstanceOf(\PHPStan\Type\MixedType::class, $methodReturnType);
        $this->assertTrue($methodReturnType->isExplicitMixed());
        $methodParameterType = $methodVariant->getParameters()[0]->getType();
        $this->assertInstanceOf(\PHPStan\Type\MixedType::class, $methodParameterType);
        $this->assertTrue($methodParameterType->isExplicitMixed());
        $function = $reflectionProvider->getFunction(new \PhpParser\Node\Name('_PhpScoperabd03f0baf05\\NativeMixedType\\doFoo'), null);
        $functionVariant = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($function->getVariants());
        $functionReturnType = $functionVariant->getReturnType();
        $this->assertInstanceOf(\PHPStan\Type\MixedType::class, $functionReturnType);
        $this->assertTrue($functionReturnType->isExplicitMixed());
        $functionParameterType = $functionVariant->getParameters()[0]->getType();
        $this->assertInstanceOf(\PHPStan\Type\MixedType::class, $functionParameterType);
        $this->assertTrue($functionParameterType->isExplicitMixed());
    }
}
