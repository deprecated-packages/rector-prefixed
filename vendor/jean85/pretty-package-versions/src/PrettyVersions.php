<?php

namespace _PhpScoperfce0de0de1ce\Jean85;

use _PhpScoperfce0de0de1ce\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \_PhpScoperfce0de0de1ce\Jean85\Version
    {
        return new \_PhpScoperfce0de0de1ce\Jean85\Version($packageName, \_PhpScoperfce0de0de1ce\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \_PhpScoperfce0de0de1ce\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \_PhpScoperfce0de0de1ce\Jean85\Version
    {
        return self::getVersion(\_PhpScoperfce0de0de1ce\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
