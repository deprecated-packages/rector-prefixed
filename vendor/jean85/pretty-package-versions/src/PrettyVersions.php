<?php

namespace _PhpScoper26e51eeacccf\Jean85;

use _PhpScoper26e51eeacccf\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \_PhpScoper26e51eeacccf\Jean85\Version
    {
        return new \_PhpScoper26e51eeacccf\Jean85\Version($packageName, \_PhpScoper26e51eeacccf\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \_PhpScoper26e51eeacccf\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \_PhpScoper26e51eeacccf\Jean85\Version
    {
        return self::getVersion(\_PhpScoper26e51eeacccf\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
