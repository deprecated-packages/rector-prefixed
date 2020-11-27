<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

use _PhpScoper26e51eeacccf\NativeUnionTypes\Foo;
use PhpParser\Node\Name;
use PHPStan\Testing\TestCase;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
class UnionTypesTest extends \PHPStan\Testing\TestCase
{
    public function testUnionTypes() : void
    {
        if (\PHP_VERSION_ID < 80000 && !self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires PHP 8.0');
        }
        require_once __DIR__ . '/../../../stubs/runtime/ReflectionUnionType.php';
        $reflectionProvider = $this->createBroker();
        $class = $reflectionProvider->getClass(\_PhpScoper26e51eeacccf\NativeUnionTypes\Foo::class);
        $propertyType = $class->getNativeProperty('fooProp')->getNativeType();
        $this->assertInstanceOf(\PHPStan\Type\UnionType::class, $propertyType);
        $this->assertSame('bool|int', $propertyType->describe(\PHPStan\Type\VerbosityLevel::precise()));
        $method = $class->getNativeMethod('doFoo');
        $methodVariant = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants());
        $methodReturnType = $methodVariant->getReturnType();
        $this->assertInstanceOf(\PHPStan\Type\UnionType::class, $methodReturnType);
        $this->assertSame('_PhpScoper26e51eeacccf\\NativeUnionTypes\\Bar|NativeUnionTypes\\Foo', $methodReturnType->describe(\PHPStan\Type\VerbosityLevel::precise()));
        $methodParameterType = $methodVariant->getParameters()[0]->getType();
        $this->assertInstanceOf(\PHPStan\Type\UnionType::class, $methodParameterType);
        $this->assertSame('bool|int', $methodParameterType->describe(\PHPStan\Type\VerbosityLevel::precise()));
        $function = $reflectionProvider->getFunction(new \PhpParser\Node\Name('_PhpScoper26e51eeacccf\\NativeUnionTypes\\doFoo'), null);
        $functionVariant = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($function->getVariants());
        $functionReturnType = $functionVariant->getReturnType();
        $this->assertInstanceOf(\PHPStan\Type\UnionType::class, $functionReturnType);
        $this->assertSame('_PhpScoper26e51eeacccf\\NativeUnionTypes\\Bar|NativeUnionTypes\\Foo', $functionReturnType->describe(\PHPStan\Type\VerbosityLevel::precise()));
        $functionParameterType = $functionVariant->getParameters()[0]->getType();
        $this->assertInstanceOf(\PHPStan\Type\UnionType::class, $functionParameterType);
        $this->assertSame('bool|int', $functionParameterType->describe(\PHPStan\Type\VerbosityLevel::precise()));
    }
}
