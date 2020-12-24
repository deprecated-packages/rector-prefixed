<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Process\Runnable;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Promise\CancellablePromiseInterface;
interface Runnable
{
    public function getName() : string;
    public function run() : \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Promise\CancellablePromiseInterface;
    public function cancel() : void;
}
