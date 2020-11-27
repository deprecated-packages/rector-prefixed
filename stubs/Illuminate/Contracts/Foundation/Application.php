<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Illuminate\Contracts\Foundation;

if (\class_exists('_PhpScoper26e51eeacccf\\Illuminate\\Contracts\\Foundation\\Application')) {
    return;
}
final class Application
{
    public function tagged(string $tagName) : iterable
    {
        return [];
    }
}
