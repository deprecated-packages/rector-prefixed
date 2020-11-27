<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Tests\Console\Command;

use Iterator;
use _PhpScoperbd5d0c5f7638\PHPUnit\Framework\TestCase;
use Symplify\PackageBuilder\Console\Command\CommandNaming;
final class CommandNamingTest extends \_PhpScoperbd5d0c5f7638\PHPUnit\Framework\TestCase
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
        (yield ['_PhpScoperbd5d0c5f7638\\AlsoNamespace\\SomeNameCommand', 'some-name']);
        (yield ['_PhpScoperbd5d0c5f7638\\AlsoNamespace\\ECSCommand', 'ecs']);
        (yield ['_PhpScoperbd5d0c5f7638\\AlsoNamespace\\PHPStanCommand', 'php-stan']);
    }
}
