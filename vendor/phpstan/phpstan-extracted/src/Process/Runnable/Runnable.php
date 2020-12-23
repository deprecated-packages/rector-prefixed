<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Process\Runnable;

use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\React\Promise\CancellablePromiseInterface;
interface Runnable
{
    public function getName() : string;
    public function run() : \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\React\Promise\CancellablePromiseInterface;
    public function cancel() : void;
}
