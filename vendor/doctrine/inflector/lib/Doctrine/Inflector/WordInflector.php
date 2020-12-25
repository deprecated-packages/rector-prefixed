<?php

declare (strict_types=1);
namespace _PhpScoper267b3276efc2\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
