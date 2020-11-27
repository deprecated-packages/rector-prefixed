<?php

declare (strict_types=1);
namespace PHPStan\Compiler\Process;

use _PhpScopera143bcca66cb\PHPUnit\Framework\TestCase;
use _PhpScopera143bcca66cb\Symfony\Component\Console\Output\OutputInterface;
final class DefaultProcessFactoryTest extends \_PhpScopera143bcca66cb\PHPUnit\Framework\TestCase
{
    public function testCreate() : void
    {
        $output = $this->createMock(\_PhpScopera143bcca66cb\Symfony\Component\Console\Output\OutputInterface::class);
        $output->expects(self::once())->method('write');
        $factory = new \PHPStan\Compiler\Process\DefaultProcessFactory();
        $factory->setOutput($output);
        $process = $factory->create(['ls'], __DIR__)->getProcess();
        self::assertSame('\'ls\'', $process->getCommandLine());
        self::assertSame(__DIR__, $process->getWorkingDirectory());
    }
}
