<?php

namespace _PhpScoperbd5d0c5f7638\Jean85;

use _PhpScoperbd5d0c5f7638\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \_PhpScoperbd5d0c5f7638\Jean85\Version
    {
        return new \_PhpScoperbd5d0c5f7638\Jean85\Version($packageName, \_PhpScoperbd5d0c5f7638\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \_PhpScoperbd5d0c5f7638\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \_PhpScoperbd5d0c5f7638\Jean85\Version
    {
        return self::getVersion(\_PhpScoperbd5d0c5f7638\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
