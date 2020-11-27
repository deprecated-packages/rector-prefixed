<?php

namespace _PhpScoper006a73f0e455\Jean85;

use _PhpScoper006a73f0e455\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \_PhpScoper006a73f0e455\Jean85\Version
    {
        return new \_PhpScoper006a73f0e455\Jean85\Version($packageName, \_PhpScoper006a73f0e455\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \_PhpScoper006a73f0e455\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \_PhpScoper006a73f0e455\Jean85\Version
    {
        return self::getVersion(\_PhpScoper006a73f0e455\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
