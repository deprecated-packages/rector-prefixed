<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Parallel;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Socket\TcpServer;
use function array_key_exists;
class ProcessPool
{
    /** @var TcpServer */
    private $server;
    /** @var array<string, Process> */
    private $processes = [];
    public function __construct(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Socket\TcpServer $server)
    {
        $this->server = $server;
    }
    public function getProcess(string $identifier) : \_PhpScoperb75b35f52b74\PHPStan\Parallel\Process
    {
        if (!\array_key_exists($identifier, $this->processes)) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException(\sprintf('Process %s not found.', $identifier));
        }
        return $this->processes[$identifier];
    }
    public function attachProcess(string $identifier, \_PhpScoperb75b35f52b74\PHPStan\Parallel\Process $process) : void
    {
        $this->processes[$identifier] = $process;
    }
    public function tryQuitProcess(string $identifier) : void
    {
        if (!\array_key_exists($identifier, $this->processes)) {
            return;
        }
        $this->quitProcess($identifier);
    }
    public function quitProcess(string $identifier) : void
    {
        $process = $this->getProcess($identifier);
        $process->quit();
        unset($this->processes[$identifier]);
        if (\count($this->processes) !== 0) {
            return;
        }
        $this->server->close();
    }
    public function quitAll() : void
    {
        foreach (\array_keys($this->processes) as $identifier) {
            $this->quitProcess($identifier);
        }
    }
}
