<?php

namespace _PhpScoper26e51eeacccf;

class DateTimeZone
{
    public function __construct(string $timezone)
    {
    }
    /**
     * @return string
     * @alias timezone_name_get
     */
    public function getName()
    {
    }
    /**
     * @return int
     * @alias timezone_offset_get
     */
    public function getOffset(\DateTimeInterface $datetime)
    {
    }
    /**
     * @return array|false
     * @alias timezone_transitions_get
     */
    public function getTransitions(int $timestampBegin = \PHP_INT_MIN, int $timestampEnd = \PHP_INT_MAX)
    {
    }
    /**
     * @return array|false
     * @alias timezone_location_get
     */
    public function getLocation()
    {
    }
    /**
     * @return array
     * @alias timezone_abbreviations_list
     */
    public static function listAbbreviations()
    {
    }
    /**
     * @return array|false
     * @alias timezone_identifiers_list
     */
    public static function listIdentifiers(int $timezoneGroup = \DateTimeZone::ALL, ?string $countryCode = null)
    {
    }
    /** @return void */
    public function __wakeup()
    {
    }
    /** @return DateTimeZone */
    public static function __set_state(array $array)
    {
    }
}
\class_alias('_PhpScoper26e51eeacccf\\DateTimeZone', 'DateTimeZone', \false);
