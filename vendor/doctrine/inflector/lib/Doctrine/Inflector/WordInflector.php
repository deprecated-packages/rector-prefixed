<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
