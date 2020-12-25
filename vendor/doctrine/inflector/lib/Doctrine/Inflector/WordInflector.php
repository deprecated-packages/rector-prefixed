<?php

declare (strict_types=1);
namespace _PhpScoper5b8c9e9ebd21\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
