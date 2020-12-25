<?php

namespace _PhpScoperbf340cb0be9d\Jean85;

use _PhpScoperbf340cb0be9d\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \_PhpScoperbf340cb0be9d\Jean85\Version
    {
        return new \_PhpScoperbf340cb0be9d\Jean85\Version($packageName, \_PhpScoperbf340cb0be9d\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \_PhpScoperbf340cb0be9d\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \_PhpScoperbf340cb0be9d\Jean85\Version
    {
        return self::getVersion(\_PhpScoperbf340cb0be9d\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
