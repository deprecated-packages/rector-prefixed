<?php

declare (strict_types=1);
namespace PHPStan\Process\Runnable;

use _PhpScoperabd03f0baf05\React\Promise\CancellablePromiseInterface;
interface Runnable
{
    public function getName() : string;
    public function run() : \_PhpScoperabd03f0baf05\React\Promise\CancellablePromiseInterface;
    public function cancel() : void;
}
