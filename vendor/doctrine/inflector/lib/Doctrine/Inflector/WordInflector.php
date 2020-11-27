<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
