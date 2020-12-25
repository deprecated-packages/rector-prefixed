<?php

declare (strict_types=1);
namespace _PhpScoper50d83356d739\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
