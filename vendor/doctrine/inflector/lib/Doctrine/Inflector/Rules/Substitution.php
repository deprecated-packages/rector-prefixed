<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules;

final class Substitution
{
    /** @var Word */
    private $from;
    /** @var Word */
    private $to;
    public function __construct(\_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word $from, \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
    public function getFrom() : \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word
    {
        return $this->from;
    }
    public function getTo() : \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word
    {
        return $this->to;
    }
}
