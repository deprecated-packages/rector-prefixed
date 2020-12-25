<?php

declare (strict_types=1);
namespace _PhpScoper17db12703726\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
