<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
