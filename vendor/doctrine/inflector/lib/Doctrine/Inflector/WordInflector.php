<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
