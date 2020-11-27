<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Doctrine\Inflector\Rules;

final class Substitution
{
    /** @var Word */
    private $from;
    /** @var Word */
    private $to;
    public function __construct(\_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Word $from, \_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Word $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
    public function getFrom() : \_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Word
    {
        return $this->from;
    }
    public function getTo() : \_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Word
    {
        return $this->to;
    }
}
