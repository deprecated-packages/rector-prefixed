<?php

declare (strict_types=1);
namespace RectorPrefix20210420\Jean85\Exception;

interface VersionMissingExceptionInterface extends \Throwable
{
    /**
     * @return $this
     */
    public static function create(string $packageName);
}
