<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Illuminate\Contracts\Foundation;

if (\class_exists('_PhpScoperbd5d0c5f7638\\Illuminate\\Contracts\\Foundation\\Application')) {
    return;
}
final class Application
{
    public function tagged(string $tagName) : iterable
    {
        return [];
    }
}
