<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
