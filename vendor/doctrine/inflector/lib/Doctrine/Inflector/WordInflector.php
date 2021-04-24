<?php

declare (strict_types=1);
namespace RectorPrefix20210424\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
