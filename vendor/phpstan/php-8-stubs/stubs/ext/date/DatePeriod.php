<?php

namespace _PhpScoperbd5d0c5f7638;

class DatePeriod implements \IteratorAggregate
{
    /**
     * @param DateTimeInterface|string $start
     * @param DateInterval|int $interval
     * @param DateTimeInterface|int $end
     * @param int $options
     */
    public function __construct($start, $interval = \UNKNOWN, $end = \UNKNOWN, $options = \UNKNOWN)
    {
    }
    /** @return DateTimeInterface */
    public function getStartDate()
    {
    }
    /** @return DateTimeInterface|null */
    public function getEndDate()
    {
    }
    /** @return DateInterval */
    public function getDateInterval()
    {
    }
    /** @return int|null */
    public function getRecurrences()
    {
    }
    /** @return void */
    public function __wakeup()
    {
    }
    /** @return DatePeriod */
    public static function __set_state(array $array)
    {
    }
    public function getIterator() : \Iterator
    {
    }
}
\class_alias('_PhpScoperbd5d0c5f7638\\DatePeriod', 'DatePeriod', \false);
