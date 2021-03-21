<?php

declare (strict_types=1);
namespace RectorPrefix20210321\Illuminate\Contracts\Foundation;

if (\class_exists('RectorPrefix20210321\\Illuminate\\Contracts\\Foundation\\Application')) {
    return;
}
final class Application
{
    public function tagged(string $tagName) : iterable
    {
        return [];
    }
}
