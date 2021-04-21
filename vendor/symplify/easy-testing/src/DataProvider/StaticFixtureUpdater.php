<?php

declare(strict_types=1);

namespace Symplify\EasyTesting\DataProvider;

use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;

final class StaticFixtureUpdater
{
    /**
     * @return void
     */
    public static function updateFixtureContent(
        SmartFileInfo $originalFileInfo,
        string $changedContent,
        SmartFileInfo $fixtureFileInfo
    ) {
        if (! getenv('UPDATE_TESTS') && ! getenv('UT')) {
            return;
        }

        $newOriginalContent = self::resolveNewFixtureContent($originalFileInfo, $changedContent);

        self::getSmartFileSystem()
            ->dumpFile($fixtureFileInfo->getRealPath(), $newOriginalContent);
    }

    /**
     * @return void
     */
    public static function updateExpectedFixtureContent(
        string $newOriginalContent,
        SmartFileInfo $expectedFixtureFileInfo
    ) {
        if (! getenv('UPDATE_TESTS') && ! getenv('UT')) {
            return;
        }

        self::getSmartFileSystem()
            ->dumpFile($expectedFixtureFileInfo->getRealPath(), $newOriginalContent);
    }

    private static function getSmartFileSystem(): SmartFileSystem
    {
        return new SmartFileSystem();
    }

    private static function resolveNewFixtureContent(SmartFileInfo $originalFileInfo, string $changedContent): string
    {
        if ($originalFileInfo->getContents() === $changedContent) {
            return $originalFileInfo->getContents();
        }

        return $originalFileInfo->getContents() . '-----' . PHP_EOL . $changedContent;
    }
}
