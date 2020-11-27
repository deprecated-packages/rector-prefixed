<?php

declare (strict_types=1);
namespace PHPStan\Compiler\Process;

use _PhpScoperbd5d0c5f7638\Symfony\Component\Console\Output\OutputInterface;
final class SymfonyProcess implements \PHPStan\Compiler\Process\Process
{
    /** @var \Symfony\Component\Process\Process<string, string> */
    private $process;
    /**
     * @param string[] $command
     * @param string $cwd
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    public function __construct(array $command, string $cwd, \_PhpScoperbd5d0c5f7638\Symfony\Component\Console\Output\OutputInterface $output)
    {
        $this->process = (new \_PhpScoperbd5d0c5f7638\Symfony\Component\Process\Process($command, $cwd, null, null, null))->mustRun(static function (string $type, string $buffer) use($output) : void {
            $output->write($buffer);
        });
    }
    /**
     * @return \Symfony\Component\Process\Process<string, string>
     */
    public function getProcess() : \_PhpScoperbd5d0c5f7638\Symfony\Component\Process\Process
    {
        return $this->process;
    }
}
