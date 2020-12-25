<?php

namespace _PhpScoper5b8c9e9ebd21\Jean85;

use _PhpScoper5b8c9e9ebd21\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \_PhpScoper5b8c9e9ebd21\Jean85\Version
    {
        return new \_PhpScoper5b8c9e9ebd21\Jean85\Version($packageName, \_PhpScoper5b8c9e9ebd21\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \_PhpScoper5b8c9e9ebd21\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \_PhpScoper5b8c9e9ebd21\Jean85\Version
    {
        return self::getVersion(\_PhpScoper5b8c9e9ebd21\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
