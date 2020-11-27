<?php

declare (strict_types=1);
namespace PHPStan\Compiler\Process;

use _PhpScopera143bcca66cb\Symfony\Component\Console\Output\OutputInterface;
interface ProcessFactory
{
    /**
     * @param string[] $command
     * @param string $cwd
     * @return \PHPStan\Compiler\Process\Process
     */
    public function create(array $command, string $cwd) : \PHPStan\Compiler\Process\Process;
    public function setOutput(\_PhpScopera143bcca66cb\Symfony\Component\Console\Output\OutputInterface $output) : void;
}
