<?php

declare (strict_types=1);
namespace RectorPrefix20210107\Symplify\PackageBuilder\Process;

use RectorPrefix20210107\Symfony\Component\Console\Output\OutputInterface;
use RectorPrefix20210107\Symfony\Component\Process\Process;
final class ProcessRunner
{
    /**
     * @param string[] $command
     */
    public function createAndRun(array $command, string $cwd, \RectorPrefix20210107\Symfony\Component\Console\Output\OutputInterface $output) : void
    {
        $process = new \RectorPrefix20210107\Symfony\Component\Process\Process($command, $cwd, null, null, null);
        $process->mustRun(static function (string $type, string $buffer) use($output) : void {
            $output->write($buffer);
        });
    }
}
