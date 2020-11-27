<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Doctrine\Inflector\Rules;

final class Substitution
{
    /** @var Word */
    private $from;
    /** @var Word */
    private $to;
    public function __construct(\_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word $from, \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
    public function getFrom() : \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word
    {
        return $this->from;
    }
    public function getTo() : \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word
    {
        return $this->to;
    }
}
