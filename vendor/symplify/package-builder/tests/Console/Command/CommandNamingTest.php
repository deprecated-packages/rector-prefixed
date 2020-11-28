<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Tests\Console\Command;

use Iterator;
use _PhpScoperabd03f0baf05\PHPUnit\Framework\TestCase;
use Symplify\PackageBuilder\Console\Command\CommandNaming;
final class CommandNamingTest extends \_PhpScoperabd03f0baf05\PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider provideDataForClassToName()
     */
    public function test(string $commandClass, string $expectedCommandName) : void
    {
        $this->assertSame($expectedCommandName, \Symplify\PackageBuilder\Console\Command\CommandNaming::classToName($commandClass));
    }
    public function provideDataForClassToName() : \Iterator
    {
        (yield ['SomeNameCommand', 'some-name']);
        (yield ['_PhpScoperabd03f0baf05\\AlsoNamespace\\SomeNameCommand', 'some-name']);
        (yield ['_PhpScoperabd03f0baf05\\AlsoNamespace\\ECSCommand', 'ecs']);
        (yield ['_PhpScoperabd03f0baf05\\AlsoNamespace\\PHPStanCommand', 'php-stan']);
    }
}
