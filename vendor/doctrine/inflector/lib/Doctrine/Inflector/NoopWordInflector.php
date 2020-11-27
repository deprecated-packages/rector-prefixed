<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Doctrine\Inflector;

class NoopWordInflector implements \_PhpScoper006a73f0e455\Doctrine\Inflector\WordInflector
{
    public function inflect(string $word) : string
    {
        return $word;
    }
}
