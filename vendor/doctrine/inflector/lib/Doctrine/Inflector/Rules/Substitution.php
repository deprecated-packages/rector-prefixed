<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Doctrine\Inflector\Rules;

final class Substitution
{
    /** @var Word */
    private $from;
    /** @var Word */
    private $to;
    public function __construct(\_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Word $from, \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Word $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
    public function getFrom() : \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Word
    {
        return $this->from;
    }
    public function getTo() : \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Word
    {
        return $this->to;
    }
}
