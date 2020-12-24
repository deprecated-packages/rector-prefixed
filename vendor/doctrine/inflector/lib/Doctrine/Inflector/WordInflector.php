<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
