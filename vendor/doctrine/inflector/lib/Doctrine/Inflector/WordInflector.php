<?php

declare (strict_types=1);
namespace _PhpScoperf18a0c41e2d2\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
