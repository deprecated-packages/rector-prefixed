<?php

namespace RectorPrefix2020DecSat\Jean85;

use RectorPrefix2020DecSat\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \RectorPrefix2020DecSat\Jean85\Version
    {
        return new \RectorPrefix2020DecSat\Jean85\Version($packageName, \RectorPrefix2020DecSat\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \RectorPrefix2020DecSat\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \RectorPrefix2020DecSat\Jean85\Version
    {
        return self::getVersion(\RectorPrefix2020DecSat\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
