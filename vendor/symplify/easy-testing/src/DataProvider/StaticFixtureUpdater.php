<?php

declare (strict_types=1);
namespace RectorPrefix20210408\Symplify\EasyTesting\DataProvider;

use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileSystem;
final class StaticFixtureUpdater
{
    public static function updateFixtureContent(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, string $changedContent, \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo) : void
    {
        if (!\getenv('UPDATE_TESTS') && !\getenv('UT')) {
            return;
        }
        $newOriginalContent = self::resolveNewFixtureContent($originalFileInfo, $changedContent);
        self::getSmartFileSystem()->dumpFile($fixtureFileInfo->getRealPath(), $newOriginalContent);
    }
    public static function updateExpectedFixtureContent(string $newOriginalContent, \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $expectedFixtureFileInfo) : void
    {
        if (!\getenv('UPDATE_TESTS') && !\getenv('UT')) {
            return;
        }
        self::getSmartFileSystem()->dumpFile($expectedFixtureFileInfo->getRealPath(), $newOriginalContent);
    }
    private static function getSmartFileSystem() : \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileSystem
    {
        return new \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileSystem();
    }
    private static function resolveNewFixtureContent(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, string $changedContent) : string
    {
        if ($originalFileInfo->getContents() === $changedContent) {
            return $originalFileInfo->getContents();
        }
        return $originalFileInfo->getContents() . '-----' . \PHP_EOL . $changedContent;
    }
}
