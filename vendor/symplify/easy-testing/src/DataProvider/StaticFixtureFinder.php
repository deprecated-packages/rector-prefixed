<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\EasyTesting\DataProvider;

use Iterator;
use _PhpScopere8e811afab72\Symfony\Component\Finder\Finder;
use _PhpScopere8e811afab72\Symfony\Component\Finder\SplFileInfo;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class StaticFixtureFinder
{
    public static function yieldDirectory(string $directory, string $suffix = '*.php.inc') : \Iterator
    {
        $fileInfos = self::findFilesInDirectory($directory, $suffix);
        foreach ($fileInfos as $fileInfo) {
            (yield [new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo($fileInfo->getRealPath())]);
        }
    }
    /**
     * @return SplFileInfo[]
     */
    private static function findFilesInDirectory(string $directory, string $suffix) : array
    {
        $finder = \_PhpScopere8e811afab72\Symfony\Component\Finder\Finder::create()->in($directory)->files()->name($suffix);
        $fileInfos = \iterator_to_array($finder);
        return \array_values($fileInfos);
    }
}
