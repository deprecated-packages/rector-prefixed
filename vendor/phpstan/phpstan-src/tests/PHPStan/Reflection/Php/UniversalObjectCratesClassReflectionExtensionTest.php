<?php

declare (strict_types=1);
namespace PHPStan\Reflection\Php;

use PHPStan\Broker\Broker;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
class UniversalObjectCratesClassReflectionExtensionTest extends \PHPStan\Testing\TestCase
{
    public function testNonexistentClass() : void
    {
        $broker = self::getContainer()->getByType(\PHPStan\Broker\Broker::class);
        $extension = new \PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension(['NonexistentClass', 'stdClass']);
        $extension->setBroker($broker);
        $this->assertTrue($extension->hasProperty($broker->getClass(\stdClass::class), 'foo'));
    }
    public function testDifferentGetSetType() : void
    {
        require_once __DIR__ . '/data/universal-object-crates.php';
        $broker = self::getContainer()->getByType(\PHPStan\Broker\Broker::class);
        $extension = new \PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension(['_PhpScoper88fe6e0ad041\\UniversalObjectCreates\\DifferentGetSetTypes']);
        $extension->setBroker($broker);
        $this->assertEquals(new \PHPStan\Type\ObjectType('_PhpScoper88fe6e0ad041\\UniversalObjectCreates\\DifferentGetSetTypesValue'), $extension->getProperty($broker->getClass('_PhpScoper88fe6e0ad041\\UniversalObjectCreates\\DifferentGetSetTypes'), 'foo')->getReadableType());
        $this->assertEquals(new \PHPStan\Type\StringType(), $extension->getProperty($broker->getClass('_PhpScoper88fe6e0ad041\\UniversalObjectCreates\\DifferentGetSetTypes'), 'foo')->getWritableType());
    }
}
