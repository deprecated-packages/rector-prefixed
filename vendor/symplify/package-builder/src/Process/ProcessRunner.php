<?php

declare (strict_types=1);
namespace RectorPrefix20201228\Symplify\PackageBuilder\Process;

use RectorPrefix20201228\Symfony\Component\Console\Output\OutputInterface;
use RectorPrefix20201228\Symfony\Component\Process\Process;
final class ProcessRunner
{
    /**
     * @param string[] $command
     */
    public function createAndRun(array $command, string $cwd, \RectorPrefix20201228\Symfony\Component\Console\Output\OutputInterface $output) : void
    {
        $process = new \RectorPrefix20201228\Symfony\Component\Process\Process($command, $cwd, null, null, null);
        $process->mustRun(static function (string $type, string $buffer) use($output) : void {
            $output->write($buffer);
        });
    }
}
