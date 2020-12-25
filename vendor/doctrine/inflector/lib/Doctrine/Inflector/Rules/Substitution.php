<?php

declare (strict_types=1);
namespace _PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules;

final class Substitution
{
    /** @var Word */
    private $from;
    /** @var Word */
    private $to;
    public function __construct(\_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Word $from, \_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Word $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
    public function getFrom() : \_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Word
    {
        return $this->from;
    }
    public function getTo() : \_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Word
    {
        return $this->to;
    }
}
