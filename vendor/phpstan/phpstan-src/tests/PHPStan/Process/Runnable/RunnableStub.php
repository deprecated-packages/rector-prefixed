<?php

declare (strict_types=1);
namespace PHPStan\Process\Runnable;

use _PhpScopera143bcca66cb\React\Promise\CancellablePromiseInterface;
use _PhpScopera143bcca66cb\React\Promise\Deferred;
class RunnableStub implements \PHPStan\Process\Runnable\Runnable
{
    /** @var string */
    private $name;
    /** @var Deferred */
    private $deferred;
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->deferred = new \_PhpScopera143bcca66cb\React\Promise\Deferred();
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function finish() : void
    {
        $this->deferred->resolve();
    }
    public function run() : \_PhpScopera143bcca66cb\React\Promise\CancellablePromiseInterface
    {
        /** @var CancellablePromiseInterface */
        return $this->deferred->promise();
    }
    public function cancel() : void
    {
        $this->deferred->reject(new \PHPStan\Process\Runnable\RunnableCanceledException(\sprintf('Runnable %s canceled', $this->getName())));
    }
}
