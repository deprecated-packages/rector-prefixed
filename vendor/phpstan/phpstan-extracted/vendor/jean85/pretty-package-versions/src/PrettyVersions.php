<?php

namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Jean85;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Jean85\Version
    {
        return new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Jean85\Version($packageName, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Jean85\Version
    {
        return self::getVersion(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
