<?php

declare (strict_types=1);
namespace PHPStan\Compiler\Process;

interface Process
{
    /**
     * @return \Symfony\Component\Process\Process<string, string>
     */
    public function getProcess() : \_PhpScoperbd5d0c5f7638\Symfony\Component\Process\Process;
}
