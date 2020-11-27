<?php

namespace _PhpScopera143bcca66cb\Jean85;

use _PhpScopera143bcca66cb\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \_PhpScopera143bcca66cb\Jean85\Version
    {
        return new \_PhpScopera143bcca66cb\Jean85\Version($packageName, \_PhpScopera143bcca66cb\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \_PhpScopera143bcca66cb\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \_PhpScopera143bcca66cb\Jean85\Version
    {
        return self::getVersion(\_PhpScopera143bcca66cb\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
