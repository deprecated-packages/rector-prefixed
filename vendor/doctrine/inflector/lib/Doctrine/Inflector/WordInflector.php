<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
