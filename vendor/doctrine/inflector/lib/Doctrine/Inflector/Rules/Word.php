<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Doctrine\Inflector\Rules;

class Word
{
    /** @var string */
    private $word;
    public function __construct(string $word)
    {
        $this->word = $word;
    }
    public function getWord() : string
    {
        return $this->word;
    }
}
