<?php

declare (strict_types=1);
namespace RectorPrefix20210408\Jean85;

use Composer\InstalledVersions;
use RectorPrefix20210408\Jean85\Exception\ProvidedPackageException;
use RectorPrefix20210408\Jean85\Exception\ReplacedPackageException;
use RectorPrefix20210408\Jean85\Exception\VersionMissingExceptionInterface;
class PrettyVersions
{
    /**
     * @throws VersionMissingExceptionInterface When a package is provided ({@see ProvidedPackageException}) or replaced ({@see ReplacedPackageException})
     */
    public static function getVersion(string $packageName) : \RectorPrefix20210408\Jean85\Version
    {
        if (isset(\Composer\InstalledVersions::getRawData()['versions'][$packageName]['provided'])) {
            throw \RectorPrefix20210408\Jean85\Exception\ProvidedPackageException::create($packageName);
        }
        if (isset(\Composer\InstalledVersions::getRawData()['versions'][$packageName]['replaced'])) {
            throw \RectorPrefix20210408\Jean85\Exception\ReplacedPackageException::create($packageName);
        }
        return new \RectorPrefix20210408\Jean85\Version($packageName, \Composer\InstalledVersions::getPrettyVersion($packageName), \Composer\InstalledVersions::getReference($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \Composer\InstalledVersions::getRootPackage()['name'];
    }
    public static function getRootPackageVersion() : \RectorPrefix20210408\Jean85\Version
    {
        return new \RectorPrefix20210408\Jean85\Version(self::getRootPackageName(), \Composer\InstalledVersions::getRootPackage()['pretty_version'], \Composer\InstalledVersions::getRootPackage()['reference']);
    }
}
