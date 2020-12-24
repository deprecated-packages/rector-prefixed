<?php

namespace _PhpScoperb75b35f52b74\Jean85;

use _PhpScoperb75b35f52b74\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \_PhpScoperb75b35f52b74\Jean85\Version
    {
        return new \_PhpScoperb75b35f52b74\Jean85\Version($packageName, \_PhpScoperb75b35f52b74\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \_PhpScoperb75b35f52b74\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \_PhpScoperb75b35f52b74\Jean85\Version
    {
        return self::getVersion(\_PhpScoperb75b35f52b74\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
