<?php

declare (strict_types=1);
namespace PHPStan\Compiler\Process;

use _PhpScoper88fe6e0ad041\PHPUnit\Framework\TestCase;
use _PhpScoper88fe6e0ad041\Symfony\Component\Console\Output\OutputInterface;
final class SymfonyProcessTest extends \_PhpScoper88fe6e0ad041\PHPUnit\Framework\TestCase
{
    public function testGetProcess() : void
    {
        $output = $this->createMock(\_PhpScoper88fe6e0ad041\Symfony\Component\Console\Output\OutputInterface::class);
        $output->expects(self::once())->method('write');
        $process = (new \PHPStan\Compiler\Process\SymfonyProcess(['ls'], __DIR__, $output))->getProcess();
        self::assertSame('\'ls\'', $process->getCommandLine());
        self::assertSame(__DIR__, $process->getWorkingDirectory());
    }
}
