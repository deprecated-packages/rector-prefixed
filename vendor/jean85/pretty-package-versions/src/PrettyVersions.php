<?php

namespace _PhpScoper567b66d83109\Jean85;

use _PhpScoper567b66d83109\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \_PhpScoper567b66d83109\Jean85\Version
    {
        return new \_PhpScoper567b66d83109\Jean85\Version($packageName, \_PhpScoper567b66d83109\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \_PhpScoper567b66d83109\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \_PhpScoper567b66d83109\Jean85\Version
    {
        return self::getVersion(\_PhpScoper567b66d83109\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
