<?php

declare (strict_types=1);
namespace PHPStan\Process\Runnable;

use _PhpScoper26e51eeacccf\React\Promise\CancellablePromiseInterface;
interface Runnable
{
    public function getName() : string;
    public function run() : \_PhpScoper26e51eeacccf\React\Promise\CancellablePromiseInterface;
    public function cancel() : void;
}
