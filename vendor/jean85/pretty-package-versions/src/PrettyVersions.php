<?php

namespace _PhpScoper17db12703726\Jean85;

use _PhpScoper17db12703726\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \_PhpScoper17db12703726\Jean85\Version
    {
        return new \_PhpScoper17db12703726\Jean85\Version($packageName, \_PhpScoper17db12703726\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \_PhpScoper17db12703726\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \_PhpScoper17db12703726\Jean85\Version
    {
        return self::getVersion(\_PhpScoper17db12703726\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
