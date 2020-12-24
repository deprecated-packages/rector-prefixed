<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Doctrine\Inflector\Rules;

final class Substitution
{
    /** @var Word */
    private $from;
    /** @var Word */
    private $to;
    public function __construct(\_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Word $from, \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Word $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
    public function getFrom() : \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Word
    {
        return $this->from;
    }
    public function getTo() : \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Word
    {
        return $this->to;
    }
}
