<?php

declare (strict_types=1);
namespace PHPStan\Reflection\Type;

use PHPStan\Reflection\MethodReflection;
use PHPStan\TrinaryLogic;
class UnionTypeMethodReflectionTest extends \PHPStan\Testing\TestCase
{
    public function testCollectsDeprecatedMessages() : void
    {
        $reflection = new \PHPStan\Reflection\Type\UnionTypeMethodReflection('foo', [$this->createDeprecatedMethod(\PHPStan\TrinaryLogic::createYes(), 'Deprecated'), $this->createDeprecatedMethod(\PHPStan\TrinaryLogic::createMaybe(), 'Maybe deprecated'), $this->createDeprecatedMethod(\PHPStan\TrinaryLogic::createNo(), 'Not deprecated')]);
        $this->assertSame('Deprecated', $reflection->getDeprecatedDescription());
    }
    public function testMultipleDeprecationsAreJoined() : void
    {
        $reflection = new \PHPStan\Reflection\Type\UnionTypeMethodReflection('foo', [$this->createDeprecatedMethod(\PHPStan\TrinaryLogic::createYes(), 'Deprecated #1'), $this->createDeprecatedMethod(\PHPStan\TrinaryLogic::createYes(), 'Deprecated #2')]);
        $this->assertSame('Deprecated #1 Deprecated #2', $reflection->getDeprecatedDescription());
    }
    private function createDeprecatedMethod(\PHPStan\TrinaryLogic $deprecated, ?string $deprecationText) : \PHPStan\Reflection\MethodReflection
    {
        $method = $this->createMock(\PHPStan\Reflection\MethodReflection::class);
        $method->method('isDeprecated')->willReturn($deprecated);
        $method->method('getDeprecatedDescription')->willReturn($deprecationText);
        return $method;
    }
}
