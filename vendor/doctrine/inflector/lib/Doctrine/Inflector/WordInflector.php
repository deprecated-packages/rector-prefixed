<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
