<?php

declare (strict_types=1);
namespace PHPStan\Reflection\Annotations;

use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
class InternalAnnotationsTest extends \PHPStan\Testing\TestCase
{
    public function dataInternalAnnotations() : array
    {
        return [[\false, \_PhpScoperabd03f0baf05\InternalAnnotations\Foo::class, ['constant' => ['FOO'], 'method' => ['foo', 'staticFoo'], 'property' => ['foo', 'staticFoo']]], [\true, \_PhpScoperabd03f0baf05\InternalAnnotations\InternalFoo::class, ['constant' => ['INTERNAL_FOO'], 'method' => ['internalFoo', 'internalStaticFoo'], 'property' => ['internalFoo', 'internalStaticFoo']]], [\false, \_PhpScoperabd03f0baf05\InternalAnnotations\FooInterface::class, ['constant' => ['FOO'], 'method' => ['foo', 'staticFoo']]], [\true, \_PhpScoperabd03f0baf05\InternalAnnotations\InternalFooInterface::class, ['constant' => ['INTERNAL_FOO'], 'method' => ['internalFoo', 'internalStaticFoo']]], [\false, \_PhpScoperabd03f0baf05\InternalAnnotations\FooTrait::class, ['method' => ['foo', 'staticFoo'], 'property' => ['foo', 'staticFoo']]], [\true, \_PhpScoperabd03f0baf05\InternalAnnotations\InternalFooTrait::class, ['method' => ['internalFoo', 'internalStaticFoo'], 'property' => ['internalFoo', 'internalStaticFoo']]]];
    }
    /**
     * @dataProvider dataInternalAnnotations
     * @param bool $internal
     * @param string $className
     * @param array<string, mixed> $internalAnnotations
     */
    public function testInternalAnnotations(bool $internal, string $className, array $internalAnnotations) : void
    {
        /** @var Broker $broker */
        $broker = self::getContainer()->getByType(\PHPStan\Broker\Broker::class);
        $class = $broker->getClass($className);
        $scope = $this->createMock(\PHPStan\Analyser\Scope::class);
        $scope->method('isInClass')->willReturn(\true);
        $scope->method('getClassReflection')->willReturn($class);
        $scope->method('canAccessProperty')->willReturn(\true);
        $this->assertSame($internal, $class->isInternal());
        foreach ($internalAnnotations['method'] ?? [] as $methodName) {
            $methodAnnotation = $class->getMethod($methodName, $scope);
            $this->assertSame($internal, $methodAnnotation->isInternal()->yes());
        }
        foreach ($internalAnnotations['property'] ?? [] as $propertyName) {
            $propertyAnnotation = $class->getProperty($propertyName, $scope);
            $this->assertSame($internal, $propertyAnnotation->isInternal()->yes());
        }
        foreach ($internalAnnotations['constant'] ?? [] as $constantName) {
            $constantAnnotation = $class->getConstant($constantName);
            $this->assertSame($internal, $constantAnnotation->isInternal()->yes());
        }
    }
    public function testInternalUserFunctions() : void
    {
        require_once __DIR__ . '/data/annotations-internal.php';
        /** @var Broker $broker */
        $broker = self::getContainer()->getByType(\PHPStan\Broker\Broker::class);
        $this->assertFalse($broker->getFunction(new \PhpParser\Node\Name\FullyQualified('_PhpScoperabd03f0baf05\\InternalAnnotations\\foo'), null)->isInternal()->yes());
        $this->assertTrue($broker->getFunction(new \PhpParser\Node\Name\FullyQualified('_PhpScoperabd03f0baf05\\InternalAnnotations\\internalFoo'), null)->isInternal()->yes());
    }
}
