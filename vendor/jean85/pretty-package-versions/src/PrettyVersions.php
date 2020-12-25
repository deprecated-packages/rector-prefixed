<?php

namespace _PhpScoperf18a0c41e2d2\Jean85;

use _PhpScoperf18a0c41e2d2\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \_PhpScoperf18a0c41e2d2\Jean85\Version
    {
        return new \_PhpScoperf18a0c41e2d2\Jean85\Version($packageName, \_PhpScoperf18a0c41e2d2\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \_PhpScoperf18a0c41e2d2\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \_PhpScoperf18a0c41e2d2\Jean85\Version
    {
        return self::getVersion(\_PhpScoperf18a0c41e2d2\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
