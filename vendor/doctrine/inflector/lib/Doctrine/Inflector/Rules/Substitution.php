<?php

declare (strict_types=1);
namespace _PhpScoper267b3276efc2\Doctrine\Inflector\Rules;

final class Substitution
{
    /** @var Word */
    private $from;
    /** @var Word */
    private $to;
    public function __construct(\_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Word $from, \_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Word $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
    public function getFrom() : \_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Word
    {
        return $this->from;
    }
    public function getTo() : \_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Word
    {
        return $this->to;
    }
}
