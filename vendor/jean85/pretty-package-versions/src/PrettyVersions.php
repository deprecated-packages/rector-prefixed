<?php

namespace _PhpScoperabd03f0baf05\Jean85;

use _PhpScoperabd03f0baf05\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \_PhpScoperabd03f0baf05\Jean85\Version
    {
        return new \_PhpScoperabd03f0baf05\Jean85\Version($packageName, \_PhpScoperabd03f0baf05\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \_PhpScoperabd03f0baf05\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \_PhpScoperabd03f0baf05\Jean85\Version
    {
        return self::getVersion(\_PhpScoperabd03f0baf05\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
