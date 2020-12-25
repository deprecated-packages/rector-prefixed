<?php

namespace _PhpScoper50d83356d739\Jean85;

use _PhpScoper50d83356d739\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \_PhpScoper50d83356d739\Jean85\Version
    {
        return new \_PhpScoper50d83356d739\Jean85\Version($packageName, \_PhpScoper50d83356d739\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \_PhpScoper50d83356d739\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \_PhpScoper50d83356d739\Jean85\Version
    {
        return self::getVersion(\_PhpScoper50d83356d739\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
