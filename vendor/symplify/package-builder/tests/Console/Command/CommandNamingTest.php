<?php

declare (strict_types=1);
namespace RectorPrefix20210406\Symplify\PackageBuilder\Tests\Console\Command;

use Iterator;
use RectorPrefix20210406\PHPUnit\Framework\TestCase;
use RectorPrefix20210406\Symplify\PackageBuilder\Console\Command\CommandNaming;
final class CommandNamingTest extends \RectorPrefix20210406\PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider provideDataForClassToName()
     */
    public function test(string $commandClass, string $expectedCommandName) : void
    {
        $this->assertSame($expectedCommandName, \RectorPrefix20210406\Symplify\PackageBuilder\Console\Command\CommandNaming::classToName($commandClass));
    }
    public function provideDataForClassToName() : \Iterator
    {
        (yield ['SomeNameCommand', 'some-name']);
        (yield ['RectorPrefix20210406\\AlsoNamespace\\SomeNameCommand', 'some-name']);
        (yield ['RectorPrefix20210406\\AlsoNamespace\\ECSCommand', 'ecs']);
        (yield ['RectorPrefix20210406\\AlsoNamespace\\PHPStanCommand', 'php-stan']);
    }
}
