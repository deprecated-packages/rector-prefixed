<?php

declare (strict_types=1);
namespace _PhpScoper267b3276efc2\Doctrine\Inflector;

class NoopWordInflector implements \_PhpScoper267b3276efc2\Doctrine\Inflector\WordInflector
{
    public function inflect(string $word) : string
    {
        return $word;
    }
}
