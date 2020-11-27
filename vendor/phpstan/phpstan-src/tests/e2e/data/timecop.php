<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\TimecopRegressionTest;

use DateTimeImmutable;
class TimecopRegression
{
    /** @var DateTimeImmutable */
    private $bar;
    public function __construct(\DateTimeImmutable $bar)
    {
        $this->bar = $bar;
    }
    public static function create() : self
    {
        return new self(new \DateTimeImmutable());
    }
}
