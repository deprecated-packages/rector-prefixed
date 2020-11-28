<?php

declare (strict_types=1);
namespace PHPStan\Compiler\Process;

use _PhpScoperabd03f0baf05\PHPUnit\Framework\TestCase;
use _PhpScoperabd03f0baf05\Symfony\Component\Console\Output\OutputInterface;
final class SymfonyProcessTest extends \_PhpScoperabd03f0baf05\PHPUnit\Framework\TestCase
{
    public function testGetProcess() : void
    {
        $output = $this->createMock(\_PhpScoperabd03f0baf05\Symfony\Component\Console\Output\OutputInterface::class);
        $output->expects(self::once())->method('write');
        $process = (new \PHPStan\Compiler\Process\SymfonyProcess(['ls'], __DIR__, $output))->getProcess();
        self::assertSame('\'ls\'', $process->getCommandLine());
        self::assertSame(__DIR__, $process->getWorkingDirectory());
    }
}
