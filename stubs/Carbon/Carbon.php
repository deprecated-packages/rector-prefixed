<?php

namespace _PhpScoper006a73f0e455\Carbon;

use DateInterval;
use DateTimeInterface;
use DateTimeZone;
if (\class_exists('_PhpScoper006a73f0e455\\Carbon\\Carbon')) {
    return;
}
class Carbon extends \DateTime
{
    public static function now() : self
    {
        return new self();
    }
    public static function today() : self
    {
        return new self();
    }
    public function subDays(int $days) : self
    {
        return $this;
    }
}
