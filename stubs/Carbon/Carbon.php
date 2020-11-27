<?php

namespace _PhpScoper88fe6e0ad041\Carbon;

use DateInterval;
use DateTimeInterface;
use DateTimeZone;
if (\class_exists('_PhpScoper88fe6e0ad041\\Carbon\\Carbon')) {
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
