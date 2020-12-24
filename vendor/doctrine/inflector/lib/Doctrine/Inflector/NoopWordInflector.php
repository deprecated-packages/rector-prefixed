<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Doctrine\Inflector;

class NoopWordInflector implements \_PhpScopere8e811afab72\Doctrine\Inflector\WordInflector
{
    public function inflect(string $word) : string
    {
        return $word;
    }
}
