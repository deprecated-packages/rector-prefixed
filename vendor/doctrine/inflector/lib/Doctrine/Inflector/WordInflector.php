<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
