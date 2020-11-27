<?php

declare (strict_types=1);
namespace PHPStan\Process\Runnable;

use _PhpScoper88fe6e0ad041\React\Promise\CancellablePromiseInterface;
interface Runnable
{
    public function getName() : string;
    public function run() : \_PhpScoper88fe6e0ad041\React\Promise\CancellablePromiseInterface;
    public function cancel() : void;
}
