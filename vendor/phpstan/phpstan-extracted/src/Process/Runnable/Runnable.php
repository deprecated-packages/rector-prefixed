<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Process\Runnable;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Promise\CancellablePromiseInterface;
interface Runnable
{
    public function getName() : string;
    public function run() : \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Promise\CancellablePromiseInterface;
    public function cancel() : void;
}
