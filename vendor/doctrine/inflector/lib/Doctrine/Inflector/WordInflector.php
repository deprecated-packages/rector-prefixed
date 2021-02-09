<?php

declare (strict_types=1);
namespace RectorPrefix20210209\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
