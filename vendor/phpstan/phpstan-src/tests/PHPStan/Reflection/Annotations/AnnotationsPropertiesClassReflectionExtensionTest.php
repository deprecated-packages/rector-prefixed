<?php

declare (strict_types=1);
namespace PHPStan\Reflection\Annotations;

use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Type\VerbosityLevel;
class AnnotationsPropertiesClassReflectionExtensionTest extends \PHPStan\Testing\TestCase
{
    public function dataProperties() : array
    {
        return [[\_PhpScoper006a73f0e455\AnnotationsProperties\Foo::class, ['otherTest' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Foo::class, 'type' => '_PhpScoper006a73f0e455\\OtherNamespace\\Test', 'writable' => \true, 'readable' => \true], 'otherTestReadOnly' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Foo::class, 'type' => '_PhpScoper006a73f0e455\\OtherNamespace\\Ipsum', 'writable' => \false, 'readable' => \true], 'fooOrBar' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Foo::class, 'type' => '_PhpScoper006a73f0e455\\AnnotationsProperties\\Foo', 'writable' => \true, 'readable' => \true], 'conflictingProperty' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Foo::class, 'type' => '_PhpScoper006a73f0e455\\OtherNamespace\\Ipsum', 'writable' => \true, 'readable' => \true], 'interfaceProperty' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\FooInterface::class, 'type' => \_PhpScoper006a73f0e455\AnnotationsProperties\FooInterface::class, 'writable' => \true, 'readable' => \true], 'overridenProperty' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Foo::class, 'type' => \_PhpScoper006a73f0e455\AnnotationsProperties\Foo::class, 'writable' => \true, 'readable' => \true], 'overridenPropertyWithAnnotation' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Foo::class, 'type' => \_PhpScoper006a73f0e455\AnnotationsProperties\Foo::class, 'writable' => \true, 'readable' => \true]]], [\_PhpScoper006a73f0e455\AnnotationsProperties\Bar::class, ['otherTest' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Foo::class, 'type' => '_PhpScoper006a73f0e455\\OtherNamespace\\Test', 'writable' => \true, 'readable' => \true], 'otherTestReadOnly' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Foo::class, 'type' => '_PhpScoper006a73f0e455\\OtherNamespace\\Ipsum', 'writable' => \false, 'readable' => \true], 'fooOrBar' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Foo::class, 'type' => '_PhpScoper006a73f0e455\\AnnotationsProperties\\Foo', 'writable' => \true, 'readable' => \true], 'conflictingProperty' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Foo::class, 'type' => '_PhpScoper006a73f0e455\\OtherNamespace\\Ipsum', 'writable' => \true, 'readable' => \true], 'overridenProperty' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Bar::class, 'type' => \_PhpScoper006a73f0e455\AnnotationsProperties\Bar::class, 'writable' => \true, 'readable' => \true], 'overridenPropertyWithAnnotation' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Bar::class, 'type' => \_PhpScoper006a73f0e455\AnnotationsProperties\Bar::class, 'writable' => \true, 'readable' => \true], 'conflictingAnnotationProperty' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Bar::class, 'type' => \_PhpScoper006a73f0e455\AnnotationsProperties\Bar::class, 'writable' => \true, 'readable' => \true]]], [\_PhpScoper006a73f0e455\AnnotationsProperties\Baz::class, ['otherTest' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Foo::class, 'type' => '_PhpScoper006a73f0e455\\OtherNamespace\\Test', 'writable' => \true, 'readable' => \true], 'otherTestReadOnly' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Foo::class, 'type' => '_PhpScoper006a73f0e455\\OtherNamespace\\Ipsum', 'writable' => \false, 'readable' => \true], 'fooOrBar' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Foo::class, 'type' => '_PhpScoper006a73f0e455\\AnnotationsProperties\\Foo', 'writable' => \true, 'readable' => \true], 'conflictingProperty' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Baz::class, 'type' => '_PhpScoper006a73f0e455\\AnnotationsProperties\\Dolor', 'writable' => \true, 'readable' => \true], 'bazProperty' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Baz::class, 'type' => '_PhpScoper006a73f0e455\\AnnotationsProperties\\Lorem', 'writable' => \true, 'readable' => \true], 'traitProperty' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Baz::class, 'type' => '_PhpScoper006a73f0e455\\AnnotationsProperties\\BazBaz', 'writable' => \true, 'readable' => \true], 'writeOnlyProperty' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Baz::class, 'type' => 'AnnotationsProperties\\Lorem|null', 'writable' => \true, 'readable' => \false]]], [\_PhpScoper006a73f0e455\AnnotationsProperties\BazBaz::class, ['otherTest' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Foo::class, 'type' => '_PhpScoper006a73f0e455\\OtherNamespace\\Test', 'writable' => \true, 'readable' => \true], 'otherTestReadOnly' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Foo::class, 'type' => '_PhpScoper006a73f0e455\\OtherNamespace\\Ipsum', 'writable' => \false, 'readable' => \true], 'fooOrBar' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Foo::class, 'type' => '_PhpScoper006a73f0e455\\AnnotationsProperties\\Foo', 'writable' => \true, 'readable' => \true], 'conflictingProperty' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Baz::class, 'type' => '_PhpScoper006a73f0e455\\AnnotationsProperties\\Dolor', 'writable' => \true, 'readable' => \true], 'bazProperty' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Baz::class, 'type' => '_PhpScoper006a73f0e455\\AnnotationsProperties\\Lorem', 'writable' => \true, 'readable' => \true], 'traitProperty' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Baz::class, 'type' => '_PhpScoper006a73f0e455\\AnnotationsProperties\\BazBaz', 'writable' => \true, 'readable' => \true], 'writeOnlyProperty' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\Baz::class, 'type' => 'AnnotationsProperties\\Lorem|null', 'writable' => \true, 'readable' => \false], 'numericBazBazProperty' => ['class' => \_PhpScoper006a73f0e455\AnnotationsProperties\BazBaz::class, 'type' => 'float|int', 'writable' => \true, 'readable' => \true]]]];
    }
    /**
     * @dataProvider dataProperties
     * @param string $className
     * @param array<string, mixed> $properties
     */
    public function testProperties(string $className, array $properties) : void
    {
        /** @var Broker $broker */
        $broker = self::getContainer()->getByType(\PHPStan\Broker\Broker::class);
        $class = $broker->getClass($className);
        $scope = $this->createMock(\PHPStan\Analyser\Scope::class);
        $scope->method('isInClass')->willReturn(\true);
        $scope->method('getClassReflection')->willReturn($class);
        $scope->method('canAccessProperty')->willReturn(\true);
        foreach ($properties as $propertyName => $expectedPropertyData) {
            $this->assertTrue($class->hasProperty($propertyName), \sprintf('Class %s does not define property %s.', $className, $propertyName));
            $property = $class->getProperty($propertyName, $scope);
            $this->assertSame($expectedPropertyData['class'], $property->getDeclaringClass()->getName(), \sprintf('Declaring class of property $%s does not match.', $propertyName));
            $this->assertSame($expectedPropertyData['type'], $property->getReadableType()->describe(\PHPStan\Type\VerbosityLevel::precise()), \sprintf('Type of property %s::$%s does not match.', $property->getDeclaringClass()->getName(), $propertyName));
            $this->assertSame($expectedPropertyData['readable'], $property->isReadable(), \sprintf('Property %s::$%s readability is not as expected.', $property->getDeclaringClass()->getName(), $propertyName));
            $this->assertSame($expectedPropertyData['writable'], $property->isWritable(), \sprintf('Property %s::$%s writability is not as expected.', $property->getDeclaringClass()->getName(), $propertyName));
        }
    }
    public function testOverridingNativePropertiesWithAnnotationsDoesNotBreakGetNativeProperty() : void
    {
        $broker = self::getContainer()->getByType(\PHPStan\Broker\Broker::class);
        $class = $broker->getClass(\_PhpScoper006a73f0e455\AnnotationsProperties\Bar::class);
        $this->assertTrue($class->hasNativeProperty('overridenPropertyWithAnnotation'));
        $this->assertSame('_PhpScoper006a73f0e455\\AnnotationsProperties\\Foo', $class->getNativeProperty('overridenPropertyWithAnnotation')->getReadableType()->describe(\PHPStan\Type\VerbosityLevel::precise()));
    }
}
