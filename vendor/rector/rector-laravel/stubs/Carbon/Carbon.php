<?php

namespace RectorPrefix20210319\Carbon;

use DateInterval;
use DateTimeInterface;
use DateTimeZone;
if (\class_exists('RectorPrefix20210319\\Carbon\\Carbon')) {
    return;
}
class Carbon extends \DateTime
{
    /**
     * @return $this
     */
    public static function now()
    {
        return new self();
    }
    /**
     * @return $this
     */
    public static function today()
    {
        return new self();
    }
    /**
     * @return $this
     */
    public function subDays(int $days)
    {
        return $this;
    }
}
