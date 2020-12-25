<?php

declare (strict_types=1);
namespace _PhpScoper567b66d83109\Doctrine\Inflector;

class NoopWordInflector implements \_PhpScoper567b66d83109\Doctrine\Inflector\WordInflector
{
    public function inflect(string $word) : string
    {
        return $word;
    }
}
