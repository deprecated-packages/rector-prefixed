<?php

declare (strict_types=1);
namespace PHPStan\Process\Runnable;

use _PhpScoperabd03f0baf05\React\Promise\CancellablePromiseInterface;
use _PhpScoperabd03f0baf05\React\Promise\Deferred;
class RunnableStub implements \PHPStan\Process\Runnable\Runnable
{
    /** @var string */
    private $name;
    /** @var Deferred */
    private $deferred;
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->deferred = new \_PhpScoperabd03f0baf05\React\Promise\Deferred();
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function finish() : void
    {
        $this->deferred->resolve();
    }
    public function run() : \_PhpScoperabd03f0baf05\React\Promise\CancellablePromiseInterface
    {
        /** @var CancellablePromiseInterface */
        return $this->deferred->promise();
    }
    public function cancel() : void
    {
        $this->deferred->reject(new \PHPStan\Process\Runnable\RunnableCanceledException(\sprintf('Runnable %s canceled', $this->getName())));
    }
}
