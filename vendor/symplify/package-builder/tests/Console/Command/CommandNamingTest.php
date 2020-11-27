<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Tests\Console\Command;

use Iterator;
use _PhpScoper26e51eeacccf\PHPUnit\Framework\TestCase;
use Symplify\PackageBuilder\Console\Command\CommandNaming;
final class CommandNamingTest extends \_PhpScoper26e51eeacccf\PHPUnit\Framework\TestCase
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
        (yield ['_PhpScoper26e51eeacccf\\AlsoNamespace\\SomeNameCommand', 'some-name']);
        (yield ['_PhpScoper26e51eeacccf\\AlsoNamespace\\ECSCommand', 'ecs']);
        (yield ['_PhpScoper26e51eeacccf\\AlsoNamespace\\PHPStanCommand', 'php-stan']);
    }
}
