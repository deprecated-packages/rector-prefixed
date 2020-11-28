<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
