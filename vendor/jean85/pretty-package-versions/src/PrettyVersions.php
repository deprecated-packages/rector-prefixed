<?php

namespace RectorPrefix20210202\Jean85;

use RectorPrefix20210202\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \RectorPrefix20210202\Jean85\Version
    {
        return new \RectorPrefix20210202\Jean85\Version($packageName, \RectorPrefix20210202\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \RectorPrefix20210202\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \RectorPrefix20210202\Jean85\Version
    {
        return self::getVersion(\RectorPrefix20210202\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
