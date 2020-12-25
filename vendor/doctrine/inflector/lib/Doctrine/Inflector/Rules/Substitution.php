<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules;

final class Substitution
{
    /** @var Word */
    private $from;
    /** @var Word */
    private $to;
    public function __construct(\_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word $from, \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
    public function getFrom() : \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word
    {
        return $this->from;
    }
    public function getTo() : \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word
    {
        return $this->to;
    }
}
