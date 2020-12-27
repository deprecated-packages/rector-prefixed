<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Process\Runnable;

interface RunnableQueueLogger
{
    public function log(string $message) : void;
}
