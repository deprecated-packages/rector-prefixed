<?php

declare (strict_types=1);
namespace RectorPrefix20210423\Jean85\Exception;

class ProvidedPackageException extends \Exception implements \RectorPrefix20210423\Jean85\Exception\VersionMissingExceptionInterface
{
    /**
     * @param string $packageName
     */
    public static function create($packageName) : \RectorPrefix20210423\Jean85\Exception\VersionMissingExceptionInterface
    {
        return new self('Cannot retrieve a version for package ' . $packageName . ' since it is provided, probably a metapackage');
    }
}
