<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Doctrine\Inflector;

class NoopWordInflector implements \_PhpScoper0a6b37af0871\Doctrine\Inflector\WordInflector
{
    public function inflect(string $word) : string
    {
        return $word;
    }
}
