<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210503\Symfony\Component\Process\Exception;

use RectorPrefix20210503\Symfony\Component\Process\Process;
/**
 * Exception for failed processes.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class ProcessFailedException extends \RectorPrefix20210503\Symfony\Component\Process\Exception\RuntimeException
{
    private $process;
    public function __construct(\RectorPrefix20210503\Symfony\Component\Process\Process $process)
    {
        if ($process->isSuccessful()) {
            throw new \RectorPrefix20210503\Symfony\Component\Process\Exception\InvalidArgumentException('Expected a failed process, but the given process was successful.');
        }
        $error = \sprintf('The command "%s" failed.' . "\n\nExit Code: %s(%s)\n\nWorking directory: %s", $process->getCommandLine(), $process->getExitCode(), $process->getExitCodeText(), $process->getWorkingDirectory());
        if (!$process->isOutputDisabled()) {
            $error .= \sprintf("\n\nOutput:\n================\n%s\n\nError Output:\n================\n%s", $process->getOutput(), $process->getErrorOutput());
        }
        parent::__construct($error);
        $this->process = $process;
    }
    public function getProcess()
    {
        return $this->process;
    }
}
