<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Tests\Console\Command;

use Iterator;
use _PhpScopera143bcca66cb\PHPUnit\Framework\TestCase;
use Symplify\PackageBuilder\Console\Command\CommandNaming;
final class CommandNamingTest extends \_PhpScopera143bcca66cb\PHPUnit\Framework\TestCase
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
        (yield ['_PhpScopera143bcca66cb\\AlsoNamespace\\SomeNameCommand', 'some-name']);
        (yield ['_PhpScopera143bcca66cb\\AlsoNamespace\\ECSCommand', 'ecs']);
        (yield ['_PhpScopera143bcca66cb\\AlsoNamespace\\PHPStanCommand', 'php-stan']);
    }
}
