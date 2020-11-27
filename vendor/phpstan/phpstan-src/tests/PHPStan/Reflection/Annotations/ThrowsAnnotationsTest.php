<?php

declare (strict_types=1);
namespace PHPStan\Reflection\Annotations;

use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Type\VerbosityLevel;
class ThrowsAnnotationsTest extends \PHPStan\Testing\TestCase
{
    public function dataThrowsAnnotations() : array
    {
        return [[\_PhpScoper26e51eeacccf\ThrowsAnnotations\Foo::class, ['withoutThrows' => null, 'throwsRuntime' => \RuntimeException::class, 'staticThrowsRuntime' => \RuntimeException::class]], [\_PhpScoper26e51eeacccf\ThrowsAnnotations\PhpstanFoo::class, ['withoutThrows' => 'void', 'throwsRuntime' => \RuntimeException::class, 'staticThrowsRuntime' => \RuntimeException::class]], [\_PhpScoper26e51eeacccf\ThrowsAnnotations\FooInterface::class, ['withoutThrows' => null, 'throwsRuntime' => \RuntimeException::class, 'staticThrowsRuntime' => \RuntimeException::class]], [\_PhpScoper26e51eeacccf\ThrowsAnnotations\FooTrait::class, ['withoutThrows' => null, 'throwsRuntime' => \RuntimeException::class, 'staticThrowsRuntime' => \RuntimeException::class]], [\_PhpScoper26e51eeacccf\ThrowsAnnotations\BarTrait::class, ['withoutThrows' => null, 'throwsRuntime' => \RuntimeException::class, 'staticThrowsRuntime' => \RuntimeException::class]]];
    }
    /**
     * @dataProvider dataThrowsAnnotations
     * @param string $className
     * @param array<string, mixed> $throwsAnnotations
     */
    public function testThrowsAnnotations(string $className, array $throwsAnnotations) : void
    {
        /** @var Broker $broker */
        $broker = self::getContainer()->getByType(\PHPStan\Broker\Broker::class);
        $class = $broker->getClass($className);
        $scope = $this->createMock(\PHPStan\Analyser\Scope::class);
        foreach ($throwsAnnotations as $methodName => $type) {
            $methodAnnotation = $class->getMethod($methodName, $scope);
            $throwType = $methodAnnotation->getThrowType();
            $this->assertSame($type, $throwType !== null ? $throwType->describe(\PHPStan\Type\VerbosityLevel::typeOnly()) : null);
        }
    }
    public function testThrowsOnUserFunctions() : void
    {
        require_once __DIR__ . '/data/annotations-throws.php';
        /** @var Broker $broker */
        $broker = self::getContainer()->getByType(\PHPStan\Broker\Broker::class);
        $this->assertNull($broker->getFunction(new \PhpParser\Node\Name\FullyQualified('_PhpScoper26e51eeacccf\\ThrowsAnnotations\\withoutThrows'), null)->getThrowType());
        $throwType = $broker->getFunction(new \PhpParser\Node\Name\FullyQualified('_PhpScoper26e51eeacccf\\ThrowsAnnotations\\throwsRuntime'), null)->getThrowType();
        $this->assertNotNull($throwType);
        $this->assertSame(\RuntimeException::class, $throwType->describe(\PHPStan\Type\VerbosityLevel::typeOnly()));
    }
    public function testThrowsOnNativeFunctions() : void
    {
        /** @var Broker $broker */
        $broker = self::getContainer()->getByType(\PHPStan\Broker\Broker::class);
        $this->assertNull($broker->getFunction(new \PhpParser\Node\Name('str_replace'), null)->getThrowType());
        $this->assertNull($broker->getFunction(new \PhpParser\Node\Name('get_class'), null)->getThrowType());
        $this->assertNull($broker->getFunction(new \PhpParser\Node\Name('function_exists'), null)->getThrowType());
    }
}
