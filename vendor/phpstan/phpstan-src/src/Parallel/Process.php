<?php

declare (strict_types=1);
namespace PHPStan\Parallel;

use _PhpScoper88fe6e0ad041\React\EventLoop\LoopInterface;
use _PhpScoper88fe6e0ad041\React\EventLoop\TimerInterface;
use _PhpScoper88fe6e0ad041\React\Stream\ReadableStreamInterface;
use _PhpScoper88fe6e0ad041\React\Stream\WritableStreamInterface;
class Process
{
    /**
     * @var string
     */
    private $command;
    /**
     * @var \React\ChildProcess\Process
     */
    public $process;
    /**
     * @var \React\EventLoop\LoopInterface
     */
    private $loop;
    /**
     * @var float
     */
    private $timeoutSeconds;
    /**
     * @var \React\Stream\WritableStreamInterface
     */
    private $in;
    /** @var resource */
    private $stdOut;
    /** @var resource */
    private $stdErr;
    /** @var callable(mixed[] $json) : void */
    private $onData;
    /** @var callable(\Throwable $exception) : void */
    private $onError;
    /**
     * @var \React\EventLoop\TimerInterface|null
     */
    private $timer = null;
    public function __construct(string $command, \_PhpScoper88fe6e0ad041\React\EventLoop\LoopInterface $loop, float $timeoutSeconds)
    {
        $this->command = $command;
        $this->loop = $loop;
        $this->timeoutSeconds = $timeoutSeconds;
    }
    /**
     * @param callable(mixed[] $json) : void $onData
     * @param callable(\Throwable $exception) : void $onError
     * @param callable(?int $exitCode, string $output) : void $onExit
     */
    public function start(callable $onData, callable $onError, callable $onExit) : void
    {
        $tmpStdOut = \tmpfile();
        if ($tmpStdOut === \false) {
            throw new \PHPStan\ShouldNotHappenException('Failed creating temp file for stdout.');
        }
        $tmpStdErr = \tmpfile();
        if ($tmpStdErr === \false) {
            throw new \PHPStan\ShouldNotHappenException('Failed creating temp file for stderr.');
        }
        $this->stdOut = $tmpStdOut;
        $this->stdErr = $tmpStdErr;
        $this->process = new \_PhpScoper88fe6e0ad041\React\ChildProcess\Process($this->command, null, null, [1 => $this->stdOut, 2 => $this->stdErr]);
        $this->process->start($this->loop);
        $this->onData = $onData;
        $this->onError = $onError;
        $this->process->on('exit', function ($exitCode) use($onExit) : void {
            $this->cancelTimer();
            $output = '';
            \rewind($this->stdOut);
            $stdOut = \stream_get_contents($this->stdOut);
            if (\is_string($stdOut)) {
                $output .= $stdOut;
            }
            \rewind($this->stdErr);
            $stdErr = \stream_get_contents($this->stdErr);
            if (\is_string($stdErr)) {
                $output .= $stdErr;
            }
            $onExit($exitCode, $output);
            \fclose($this->stdOut);
            \fclose($this->stdErr);
        });
    }
    private function cancelTimer() : void
    {
        if ($this->timer === null) {
            return;
        }
        $this->loop->cancelTimer($this->timer);
        $this->timer = null;
    }
    /**
     * @param mixed[] $data
     */
    public function request(array $data) : void
    {
        $this->cancelTimer();
        $this->in->write($data);
        $this->timer = $this->loop->addTimer($this->timeoutSeconds, function () : void {
            $onError = $this->onError;
            $onError(new \Exception(\sprintf('Child process timed out after %.1f seconds. Try making it longer with parallel.processTimeout setting.', $this->timeoutSeconds)));
        });
    }
    public function quit() : void
    {
        $this->cancelTimer();
        if (!$this->process->isRunning()) {
            return;
        }
        foreach ($this->process->pipes as $pipe) {
            $pipe->close();
        }
        // todo should I close/end something here or is it enough to terminate the process?
        $this->in->end();
        // todo what are all the events I should listen to?
        // process: just exit now
        // connection: connection, data, error?
    }
    public function bindConnection(\_PhpScoper88fe6e0ad041\React\Stream\ReadableStreamInterface $out, \_PhpScoper88fe6e0ad041\React\Stream\WritableStreamInterface $in) : void
    {
        $out->on('data', function (array $json) : void {
            if ($json['action'] !== 'result') {
                return;
            }
            $onData = $this->onData;
            $onData($json['result']);
        });
        $this->in = $in;
        $out->on('error', function (\Throwable $error) : void {
            $onError = $this->onError;
            $onError($error);
        });
        $in->on('error', function (\Throwable $error) : void {
            $onError = $this->onError;
            $onError($error);
        });
    }
}
