<?php

declare (strict_types=1);
namespace PHPStan\Process\Runnable;

use _PhpScopera143bcca66cb\React\Promise\CancellablePromiseInterface;
interface Runnable
{
    public function getName() : string;
    public function run() : \_PhpScopera143bcca66cb\React\Promise\CancellablePromiseInterface;
    public function cancel() : void;
}
