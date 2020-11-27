<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules;

final class Substitution
{
    /** @var Word */
    private $from;
    /** @var Word */
    private $to;
    public function __construct(\_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Word $from, \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Word $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
    public function getFrom() : \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Word
    {
        return $this->from;
    }
    public function getTo() : \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Word
    {
        return $this->to;
    }
}
