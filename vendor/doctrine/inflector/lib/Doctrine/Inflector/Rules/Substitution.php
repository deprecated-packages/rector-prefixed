<?php

declare (strict_types=1);
namespace _PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules;

final class Substitution
{
    /** @var Word */
    private $from;
    /** @var Word */
    private $to;
    public function __construct(\_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word $from, \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
    public function getFrom() : \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word
    {
        return $this->from;
    }
    public function getTo() : \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word
    {
        return $this->to;
    }
}
