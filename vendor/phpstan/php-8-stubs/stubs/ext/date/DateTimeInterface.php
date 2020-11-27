<?php

namespace _PhpScoper88fe6e0ad041;

// NB: Adding return types to methods is a BC break!
// For now only using @return annotations here.
interface DateTimeInterface
{
    /** @return string */
    public function format(string $format);
    /** @return DateTimeZone|false */
    public function getTimezone();
    /** @return int|false */
    public function getOffset();
    /** @return int|false */
    public function getTimestamp();
    /** @return DateInterval|false */
    public function diff(\DateTimeInterface $targetObject, bool $absolute = \false);
    /** @return void */
    public function __wakeup();
}
// NB: Adding return types to methods is a BC break!
// For now only using @return annotations here.
\class_alias('_PhpScoper88fe6e0ad041\\DateTimeInterface', 'DateTimeInterface', \false);
