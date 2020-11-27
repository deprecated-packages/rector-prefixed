<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Doctrine\Inflector;

class NoopWordInflector implements \_PhpScopera143bcca66cb\Doctrine\Inflector\WordInflector
{
    public function inflect(string $word) : string
    {
        return $word;
    }
}
