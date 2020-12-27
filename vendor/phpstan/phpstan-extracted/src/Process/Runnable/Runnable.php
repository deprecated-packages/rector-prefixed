<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Process\Runnable;

use RectorPrefix20201227\_HumbugBox221ad6f1b81f\React\Promise\CancellablePromiseInterface;
interface Runnable
{
    public function getName() : string;
    public function run() : \RectorPrefix20201227\_HumbugBox221ad6f1b81f\React\Promise\CancellablePromiseInterface;
    public function cancel() : void;
}
