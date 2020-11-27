<?php

declare (strict_types=1);
namespace PHPStan\Compiler\Process;

use _PhpScoper26e51eeacccf\Symfony\Component\Console\Output\OutputInterface;
interface ProcessFactory
{
    /**
     * @param string[] $command
     * @param string $cwd
     * @return \PHPStan\Compiler\Process\Process
     */
    public function create(array $command, string $cwd) : \PHPStan\Compiler\Process\Process;
    public function setOutput(\_PhpScoper26e51eeacccf\Symfony\Component\Console\Output\OutputInterface $output) : void;
}
