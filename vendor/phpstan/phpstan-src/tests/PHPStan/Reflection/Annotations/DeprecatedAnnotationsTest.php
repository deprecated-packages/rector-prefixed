<?php

declare (strict_types=1);
namespace PHPStan\Reflection\Annotations;

use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
class DeprecatedAnnotationsTest extends \PHPStan\Testing\TestCase
{
    public function dataDeprecatedAnnotations() : array
    {
        return [[\false, \_PhpScoper88fe6e0ad041\DeprecatedAnnotations\Foo::class, null, ['constant' => ['FOO' => null], 'method' => ['foo' => null, 'staticFoo' => null], 'property' => ['foo' => null, 'staticFoo' => null]]], [\true, \_PhpScoper88fe6e0ad041\DeprecatedAnnotations\DeprecatedFoo::class, 'in 1.0.0.', ['constant' => ['DEPRECATED_FOO' => 'Deprecated constant.'], 'method' => ['deprecatedFoo' => 'method.', 'deprecatedStaticFoo' => 'static method.'], 'property' => ['deprecatedFoo' => null, 'deprecatedStaticFoo' => null]]], [\false, \_PhpScoper88fe6e0ad041\DeprecatedAnnotations\FooInterface::class, null, ['constant' => ['FOO' => null], 'method' => ['foo' => null, 'staticFoo' => null]]], [\true, \_PhpScoper88fe6e0ad041\DeprecatedAnnotations\DeprecatedWithMultipleTags::class, "in Foo 1.1.0 and will be removed in 1.5.0, use\n\\Foo\\Bar\\NotDeprecated instead.", ['method' => ['deprecatedFoo' => "in Foo 1.1.0, will be removed in Foo 1.5.0, use\n\\Foo\\Bar\\NotDeprecated::replacementFoo() instead."]]]];
    }
    /**
     * @dataProvider dataDeprecatedAnnotations
     * @param bool $deprecated
     * @param string $className
     * @param string|null $classDeprecation
     * @param array<string, mixed> $deprecatedAnnotations
     */
    public function testDeprecatedAnnotations(bool $deprecated, string $className, ?string $classDeprecation, array $deprecatedAnnotations) : void
    {
        /** @var Broker $broker */
        $broker = self::getContainer()->getByType(\PHPStan\Broker\Broker::class);
        $class = $broker->getClass($className);
        $scope = $this->createMock(\PHPStan\Analyser\Scope::class);
        $scope->method('isInClass')->willReturn(\true);
        $scope->method('getClassReflection')->willReturn($class);
        $scope->method('canAccessProperty')->willReturn(\true);
        $this->assertSame($deprecated, $class->isDeprecated());
        $this->assertSame($classDeprecation, $class->getDeprecatedDescription());
        foreach ($deprecatedAnnotations['method'] ?? [] as $methodName => $deprecatedMessage) {
            $methodAnnotation = $class->getMethod($methodName, $scope);
            $this->assertSame($deprecated, $methodAnnotation->isDeprecated()->yes());
            $this->assertSame($deprecatedMessage, $methodAnnotation->getDeprecatedDescription());
        }
        foreach ($deprecatedAnnotations['property'] ?? [] as $propertyName => $deprecatedMessage) {
            $propertyAnnotation = $class->getProperty($propertyName, $scope);
            $this->assertSame($deprecated, $propertyAnnotation->isDeprecated()->yes());
            $this->assertSame($deprecatedMessage, $propertyAnnotation->getDeprecatedDescription());
        }
        foreach ($deprecatedAnnotations['constant'] ?? [] as $constantName => $deprecatedMessage) {
            $constantAnnotation = $class->getConstant($constantName);
            $this->assertSame($deprecated, $constantAnnotation->isDeprecated()->yes());
            $this->assertSame($deprecatedMessage, $constantAnnotation->getDeprecatedDescription());
        }
    }
    public function testDeprecatedUserFunctions() : void
    {
        require_once __DIR__ . '/data/annotations-deprecated.php';
        /** @var Broker $broker */
        $broker = self::getContainer()->getByType(\PHPStan\Broker\Broker::class);
        $this->assertFalse($broker->getFunction(new \PhpParser\Node\Name\FullyQualified('_PhpScoper88fe6e0ad041\\DeprecatedAnnotations\\foo'), null)->isDeprecated()->yes());
        $this->assertTrue($broker->getFunction(new \PhpParser\Node\Name\FullyQualified('_PhpScoper88fe6e0ad041\\DeprecatedAnnotations\\deprecatedFoo'), null)->isDeprecated()->yes());
    }
    public function testNonDeprecatedNativeFunctions() : void
    {
        /** @var Broker $broker */
        $broker = self::getContainer()->getByType(\PHPStan\Broker\Broker::class);
        $this->assertFalse($broker->getFunction(new \PhpParser\Node\Name('str_replace'), null)->isDeprecated()->yes());
        $this->assertFalse($broker->getFunction(new \PhpParser\Node\Name('get_class'), null)->isDeprecated()->yes());
        $this->assertFalse($broker->getFunction(new \PhpParser\Node\Name('function_exists'), null)->isDeprecated()->yes());
    }
}
