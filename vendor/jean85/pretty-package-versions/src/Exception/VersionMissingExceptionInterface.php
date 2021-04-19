<?php

declare (strict_types=1);
namespace RectorPrefix20210419\Jean85\Exception;

interface VersionMissingExceptionInterface extends \Throwable
{
    public static function create(string $packageName) : self;
}
