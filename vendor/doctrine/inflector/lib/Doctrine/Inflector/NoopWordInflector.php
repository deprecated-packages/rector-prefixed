<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d\Doctrine\Inflector;

class NoopWordInflector implements \_PhpScoperbf340cb0be9d\Doctrine\Inflector\WordInflector
{
    public function inflect(string $word) : string
    {
        return $word;
    }
}
