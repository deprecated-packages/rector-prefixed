<?php

namespace _HumbugBox221ad6f1b81f\Jean85;

use _HumbugBox221ad6f1b81f\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \_HumbugBox221ad6f1b81f\Jean85\Version
    {
        return new \_HumbugBox221ad6f1b81f\Jean85\Version($packageName, \_HumbugBox221ad6f1b81f\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \_HumbugBox221ad6f1b81f\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \_HumbugBox221ad6f1b81f\Jean85\Version
    {
        return self::getVersion(\_HumbugBox221ad6f1b81f\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
