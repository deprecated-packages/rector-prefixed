<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

use _PhpScoper88fe6e0ad041\Attributes\IsAttribute;
use _PhpScoper88fe6e0ad041\Attributes\IsAttribute2;
use _PhpScoper88fe6e0ad041\Attributes\IsAttribute3;
use _PhpScoper88fe6e0ad041\Attributes\IsNotAttribute;
use PHPStan\Broker\Broker;
use PHPStan\Php\PhpVersion;
use PHPStan\Type\FileTypeMapper;
class ClassReflectionTest extends \PHPStan\Testing\TestCase
{
    public function dataHasTraitUse() : array
    {
        return [[\_PhpScoper88fe6e0ad041\HasTraitUse\Foo::class, \true], [\_PhpScoper88fe6e0ad041\HasTraitUse\Bar::class, \true], [\_PhpScoper88fe6e0ad041\HasTraitUse\Baz::class, \false]];
    }
    /**
     * @dataProvider dataHasTraitUse
     * @param class-string $className
     * @param bool $has
     */
    public function testHasTraitUse(string $className, bool $has) : void
    {
        $broker = $this->createMock(\PHPStan\Broker\Broker::class);
        $fileTypeMapper = $this->createMock(\PHPStan\Type\FileTypeMapper::class);
        $classReflection = new \PHPStan\Reflection\ClassReflection($broker, $fileTypeMapper, new \PHPStan\Php\PhpVersion(\PHP_VERSION_ID), [], [], $className, new \ReflectionClass($className), null, null, null);
        $this->assertSame($has, $classReflection->hasTraitUse(\_PhpScoper88fe6e0ad041\HasTraitUse\FooTrait::class));
    }
    public function dataClassHierarchyDistances() : array
    {
        return [[\_PhpScoper88fe6e0ad041\HierarchyDistances\Lorem::class, [\_PhpScoper88fe6e0ad041\HierarchyDistances\Lorem::class => 0, \_PhpScoper88fe6e0ad041\HierarchyDistances\TraitTwo::class => 1, \_PhpScoper88fe6e0ad041\HierarchyDistances\TraitThree::class => 2, \_PhpScoper88fe6e0ad041\HierarchyDistances\FirstLoremInterface::class => 3, \_PhpScoper88fe6e0ad041\HierarchyDistances\SecondLoremInterface::class => 4]], [\_PhpScoper88fe6e0ad041\HierarchyDistances\Ipsum::class, \PHP_VERSION_ID < 70400 ? [\_PhpScoper88fe6e0ad041\HierarchyDistances\Ipsum::class => 0, \_PhpScoper88fe6e0ad041\HierarchyDistances\TraitOne::class => 1, \_PhpScoper88fe6e0ad041\HierarchyDistances\Lorem::class => 2, \_PhpScoper88fe6e0ad041\HierarchyDistances\TraitTwo::class => 3, \_PhpScoper88fe6e0ad041\HierarchyDistances\TraitThree::class => 4, \_PhpScoper88fe6e0ad041\HierarchyDistances\SecondLoremInterface::class => 5, \_PhpScoper88fe6e0ad041\HierarchyDistances\FirstLoremInterface::class => 6, \_PhpScoper88fe6e0ad041\HierarchyDistances\FirstIpsumInterface::class => 7, \_PhpScoper88fe6e0ad041\HierarchyDistances\ExtendedIpsumInterface::class => 8, \_PhpScoper88fe6e0ad041\HierarchyDistances\SecondIpsumInterface::class => 9, \_PhpScoper88fe6e0ad041\HierarchyDistances\ThirdIpsumInterface::class => 10] : [\_PhpScoper88fe6e0ad041\HierarchyDistances\Ipsum::class => 0, \_PhpScoper88fe6e0ad041\HierarchyDistances\TraitOne::class => 1, \_PhpScoper88fe6e0ad041\HierarchyDistances\Lorem::class => 2, \_PhpScoper88fe6e0ad041\HierarchyDistances\TraitTwo::class => 3, \_PhpScoper88fe6e0ad041\HierarchyDistances\TraitThree::class => 4, \_PhpScoper88fe6e0ad041\HierarchyDistances\FirstLoremInterface::class => 5, \_PhpScoper88fe6e0ad041\HierarchyDistances\SecondLoremInterface::class => 6, \_PhpScoper88fe6e0ad041\HierarchyDistances\FirstIpsumInterface::class => 7, \_PhpScoper88fe6e0ad041\HierarchyDistances\SecondIpsumInterface::class => 8, \_PhpScoper88fe6e0ad041\HierarchyDistances\ThirdIpsumInterface::class => 9, \_PhpScoper88fe6e0ad041\HierarchyDistances\ExtendedIpsumInterface::class => 10]]];
    }
    /**
     * @dataProvider dataClassHierarchyDistances
     * @param class-string $class
     * @param int[] $expectedDistances
     */
    public function testClassHierarchyDistances(string $class, array $expectedDistances) : void
    {
        $broker = $this->createReflectionProvider();
        $fileTypeMapper = $this->createMock(\PHPStan\Type\FileTypeMapper::class);
        $classReflection = new \PHPStan\Reflection\ClassReflection($broker, $fileTypeMapper, new \PHPStan\Php\PhpVersion(\PHP_VERSION_ID), [], [], $class, new \ReflectionClass($class), null, null, null);
        $this->assertSame($expectedDistances, $classReflection->getClassHierarchyDistances());
    }
    public function testVariadicTraitMethod() : void
    {
        /** @var Broker $broker */
        $broker = self::getContainer()->getService('broker');
        $fooReflection = $broker->getClass(\_PhpScoper88fe6e0ad041\HasTraitUse\Foo::class);
        $variadicMethod = $fooReflection->getNativeMethod('variadicMethod');
        $methodVariant = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($variadicMethod->getVariants());
        $this->assertTrue($methodVariant->isVariadic());
    }
    public function testGenericInheritance() : void
    {
        /** @var Broker $broker */
        $broker = self::getContainer()->getService('broker');
        $reflection = $broker->getClass(\_PhpScoper88fe6e0ad041\GenericInheritance\C::class);
        $this->assertSame('_PhpScoper88fe6e0ad041\\GenericInheritance\\C', $reflection->getDisplayName());
        $parent = $reflection->getParentClass();
        $this->assertNotFalse($parent);
        $this->assertSame('GenericInheritance\\C0<DateTime>', $parent->getDisplayName());
        $this->assertSame(['GenericInheritance\\I0<DateTime>', 'GenericInheritance\\I1<int>', 'GenericInheritance\\I<DateTime>'], \array_map(static function (\PHPStan\Reflection\ClassReflection $r) : string {
            return $r->getDisplayName();
        }, \array_values($reflection->getInterfaces())));
    }
    public function testGenericInheritanceOverride() : void
    {
        /** @var Broker $broker */
        $broker = self::getContainer()->getService('broker');
        $reflection = $broker->getClass(\_PhpScoper88fe6e0ad041\GenericInheritance\Override::class);
        $this->assertSame(['GenericInheritance\\I0<DateTimeInterface>', 'GenericInheritance\\I1<int>', 'GenericInheritance\\I<DateTimeInterface>'], \array_map(static function (\PHPStan\Reflection\ClassReflection $r) : string {
            return $r->getDisplayName();
        }, \array_values($reflection->getInterfaces())));
    }
    public function testIsGenericWithStubPhpDoc() : void
    {
        /** @var Broker $broker */
        $broker = self::getContainer()->getService('broker');
        $reflection = $broker->getClass(\ReflectionClass::class);
        $this->assertTrue($reflection->isGeneric());
    }
    public function dataIsAttributeClass() : array
    {
        return [[\_PhpScoper88fe6e0ad041\Attributes\IsNotAttribute::class, \false], [\_PhpScoper88fe6e0ad041\Attributes\IsAttribute::class, \true], [\_PhpScoper88fe6e0ad041\Attributes\IsAttribute2::class, \true, \Attribute::IS_REPEATABLE], [\_PhpScoper88fe6e0ad041\Attributes\IsAttribute3::class, \true, \Attribute::IS_REPEATABLE | \Attribute::TARGET_PROPERTY]];
    }
    /**
     * @dataProvider dataIsAttributeClass
     * @param string $className
     * @param bool $expected
     */
    public function testIsAttributeClass(string $className, bool $expected, int $expectedFlags = \Attribute::TARGET_ALL) : void
    {
        if (!self::$useStaticReflectionProvider && \PHP_VERSION_ID < 80000) {
            $this->markTestSkipped('Test requires PHP 8.0.');
        }
        $reflectionProvider = $this->createBroker();
        $reflection = $reflectionProvider->getClass($className);
        $this->assertSame($expected, $reflection->isAttributeClass());
        if (!$expected) {
            return;
        }
        $this->assertSame($expectedFlags, $reflection->getAttributeClassFlags());
    }
}
