<?php

declare (strict_types=1);
namespace PHPStan\Compiler\Process;

use _PhpScoperabd03f0baf05\Symfony\Component\Console\Output\OutputInterface;
final class SymfonyProcess implements \PHPStan\Compiler\Process\Process
{
    /** @var \Symfony\Component\Process\Process<string, string> */
    private $process;
    /**
     * @param string[] $command
     * @param string $cwd
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    public function __construct(array $command, string $cwd, \_PhpScoperabd03f0baf05\Symfony\Component\Console\Output\OutputInterface $output)
    {
        $this->process = (new \_PhpScoperabd03f0baf05\Symfony\Component\Process\Process($command, $cwd, null, null, null))->mustRun(static function (string $type, string $buffer) use($output) : void {
            $output->write($buffer);
        });
    }
    /**
     * @return \Symfony\Component\Process\Process<string, string>
     */
    public function getProcess() : \_PhpScoperabd03f0baf05\Symfony\Component\Process\Process
    {
        return $this->process;
    }
}
