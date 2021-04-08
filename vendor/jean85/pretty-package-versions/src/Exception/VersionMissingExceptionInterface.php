<?php

declare (strict_types=1);
namespace RectorPrefix20210408\Jean85\Exception;

interface VersionMissingExceptionInterface extends \Throwable
{
    public static function create(string $packageName) : self;
}
