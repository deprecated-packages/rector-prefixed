<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Process\Runnable;

use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\React\Promise\CancellablePromiseInterface;
interface Runnable
{
    public function getName() : string;
    public function run() : \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\React\Promise\CancellablePromiseInterface;
    public function cancel() : void;
}
