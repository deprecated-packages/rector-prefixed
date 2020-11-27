<?php

declare (strict_types=1);
namespace PHPStan\Process\Runnable;

use _PhpScoperbd5d0c5f7638\React\Promise\CancellablePromiseInterface;
interface Runnable
{
    public function getName() : string;
    public function run() : \_PhpScoperbd5d0c5f7638\React\Promise\CancellablePromiseInterface;
    public function cancel() : void;
}
