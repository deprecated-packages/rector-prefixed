<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\EasyTesting\DataProvider;

use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
final class StaticFixtureUpdater
{
    public static function updateFixtureContent(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, string $changedContent, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo) : void
    {
        if (!\getenv('UPDATE_TESTS') && !\getenv('UT')) {
            return;
        }
        $newOriginalContent = self::resolveNewFixtureContent($originalFileInfo, $changedContent);
        self::getSmartFileSystem()->dumpFile($fixtureFileInfo->getRealPath(), $newOriginalContent);
    }
    public static function updateExpectedFixtureContent(string $newOriginalContent, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $expectedFixtureFileInfo) : void
    {
        if (!\getenv('UPDATE_TESTS') && !\getenv('UT')) {
            return;
        }
        self::getSmartFileSystem()->dumpFile($expectedFixtureFileInfo->getRealPath(), $newOriginalContent);
    }
    private static function getSmartFileSystem() : \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem
    {
        return new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem();
    }
    private static function resolveNewFixtureContent(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, string $changedContent) : string
    {
        if ($originalFileInfo->getContents() === $changedContent) {
            return $originalFileInfo->getContents();
        }
        return $originalFileInfo->getContents() . '-----' . \PHP_EOL . $changedContent;
    }
}
