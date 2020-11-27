<?php

declare (strict_types=1);
namespace PHPStan\Compiler\Process;

use _PhpScoperbd5d0c5f7638\PHPUnit\Framework\TestCase;
use _PhpScoperbd5d0c5f7638\Symfony\Component\Console\Output\OutputInterface;
final class SymfonyProcessTest extends \_PhpScoperbd5d0c5f7638\PHPUnit\Framework\TestCase
{
    public function testGetProcess() : void
    {
        $output = $this->createMock(\_PhpScoperbd5d0c5f7638\Symfony\Component\Console\Output\OutputInterface::class);
        $output->expects(self::once())->method('write');
        $process = (new \PHPStan\Compiler\Process\SymfonyProcess(['ls'], __DIR__, $output))->getProcess();
        self::assertSame('\'ls\'', $process->getCommandLine());
        self::assertSame(__DIR__, $process->getWorkingDirectory());
    }
}
