<?php

declare (strict_types=1);
namespace _PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules;

final class Substitution
{
    /** @var Word */
    private $from;
    /** @var Word */
    private $to;
    public function __construct(\_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Word $from, \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Word $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
    public function getFrom() : \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Word
    {
        return $this->from;
    }
    public function getTo() : \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Word
    {
        return $this->to;
    }
}
