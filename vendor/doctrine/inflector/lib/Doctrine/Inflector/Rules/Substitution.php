<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Doctrine\Inflector\Rules;

final class Substitution
{
    /** @var Word */
    private $from;
    /** @var Word */
    private $to;
    public function __construct(\_PhpScoper0a2ac50786fa\Doctrine\Inflector\Rules\Word $from, \_PhpScoper0a2ac50786fa\Doctrine\Inflector\Rules\Word $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
    public function getFrom() : \_PhpScoper0a2ac50786fa\Doctrine\Inflector\Rules\Word
    {
        return $this->from;
    }
    public function getTo() : \_PhpScoper0a2ac50786fa\Doctrine\Inflector\Rules\Word
    {
        return $this->to;
    }
}
