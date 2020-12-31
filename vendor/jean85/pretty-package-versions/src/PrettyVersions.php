<?php

namespace RectorPrefix20201231\Jean85;

use RectorPrefix20201231\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \RectorPrefix20201231\Jean85\Version
    {
        return new \RectorPrefix20201231\Jean85\Version($packageName, \RectorPrefix20201231\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \RectorPrefix20201231\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \RectorPrefix20201231\Jean85\Version
    {
        return self::getVersion(\RectorPrefix20201231\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
