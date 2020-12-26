<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat\Doctrine\Inflector;

class NoopWordInflector implements \RectorPrefix2020DecSat\Doctrine\Inflector\WordInflector
{
    public function inflect(string $word) : string
    {
        return $word;
    }
}
