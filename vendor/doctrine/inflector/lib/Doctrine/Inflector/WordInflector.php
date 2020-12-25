<?php

declare (strict_types=1);
namespace _PhpScoper567b66d83109\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
