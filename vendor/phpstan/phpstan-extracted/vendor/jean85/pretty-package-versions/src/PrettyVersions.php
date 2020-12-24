<?php

namespace _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Jean85;

use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Jean85\Version
    {
        return new \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Jean85\Version($packageName, \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Jean85\Version
    {
        return self::getVersion(\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
