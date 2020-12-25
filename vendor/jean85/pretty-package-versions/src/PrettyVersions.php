<?php

namespace _PhpScoper267b3276efc2\Jean85;

use _PhpScoper267b3276efc2\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \_PhpScoper267b3276efc2\Jean85\Version
    {
        return new \_PhpScoper267b3276efc2\Jean85\Version($packageName, \_PhpScoper267b3276efc2\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \_PhpScoper267b3276efc2\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \_PhpScoper267b3276efc2\Jean85\Version
    {
        return self::getVersion(\_PhpScoper267b3276efc2\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
