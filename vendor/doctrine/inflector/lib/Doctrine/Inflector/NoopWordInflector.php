<?php

declare (strict_types=1);
namespace _PhpScoper50d83356d739\Doctrine\Inflector;

class NoopWordInflector implements \_PhpScoper50d83356d739\Doctrine\Inflector\WordInflector
{
    public function inflect(string $word) : string
    {
        return $word;
    }
}
