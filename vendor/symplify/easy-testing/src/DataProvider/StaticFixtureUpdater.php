<?php

declare (strict_types=1);
namespace RectorPrefix20210420\Symplify\EasyTesting\DataProvider;

use RectorPrefix20210420\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210420\Symplify\SmartFileSystem\SmartFileSystem;
final class StaticFixtureUpdater
{
    /**
     * @return void
     */
    public static function updateFixtureContent(\RectorPrefix20210420\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, string $changedContent, \RectorPrefix20210420\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo)
    {
        if (!\getenv('UPDATE_TESTS') && !\getenv('UT')) {
            return;
        }
        $newOriginalContent = self::resolveNewFixtureContent($originalFileInfo, $changedContent);
        self::getSmartFileSystem()->dumpFile($fixtureFileInfo->getRealPath(), $newOriginalContent);
    }
    /**
     * @return void
     */
    public static function updateExpectedFixtureContent(string $newOriginalContent, \RectorPrefix20210420\Symplify\SmartFileSystem\SmartFileInfo $expectedFixtureFileInfo)
    {
        if (!\getenv('UPDATE_TESTS') && !\getenv('UT')) {
            return;
        }
        self::getSmartFileSystem()->dumpFile($expectedFixtureFileInfo->getRealPath(), $newOriginalContent);
    }
    private static function getSmartFileSystem() : \RectorPrefix20210420\Symplify\SmartFileSystem\SmartFileSystem
    {
        return new \RectorPrefix20210420\Symplify\SmartFileSystem\SmartFileSystem();
    }
    private static function resolveNewFixtureContent(\RectorPrefix20210420\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, string $changedContent) : string
    {
        if ($originalFileInfo->getContents() === $changedContent) {
            return $originalFileInfo->getContents();
        }
        return $originalFileInfo->getContents() . '-----' . \PHP_EOL . $changedContent;
    }
}
