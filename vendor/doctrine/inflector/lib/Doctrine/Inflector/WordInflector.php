<?php

declare (strict_types=1);
namespace _PhpScoper5edc98a7cce2\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
