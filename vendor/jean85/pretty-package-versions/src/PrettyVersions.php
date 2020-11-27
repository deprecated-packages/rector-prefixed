<?php

namespace _PhpScoper88fe6e0ad041\Jean85;

use _PhpScoper88fe6e0ad041\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \_PhpScoper88fe6e0ad041\Jean85\Version
    {
        return new \_PhpScoper88fe6e0ad041\Jean85\Version($packageName, \_PhpScoper88fe6e0ad041\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \_PhpScoper88fe6e0ad041\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \_PhpScoper88fe6e0ad041\Jean85\Version
    {
        return self::getVersion(\_PhpScoper88fe6e0ad041\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
