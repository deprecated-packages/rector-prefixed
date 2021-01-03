<?php

declare (strict_types=1);
namespace RectorPrefix20210103\Symplify\EasyTesting\DataProvider;

use Iterator;
use RectorPrefix20210103\Symfony\Component\Finder\Finder;
use RectorPrefix20210103\Symfony\Component\Finder\SplFileInfo;
use RectorPrefix20210103\Symplify\SmartFileSystem\SmartFileInfo;
final class StaticFixtureFinder
{
    public static function yieldDirectory(string $directory, string $suffix = '*.php.inc') : \Iterator
    {
        $fileInfos = self::findFilesInDirectory($directory, $suffix);
        foreach ($fileInfos as $fileInfo) {
            (yield [new \RectorPrefix20210103\Symplify\SmartFileSystem\SmartFileInfo($fileInfo->getRealPath())]);
        }
    }
    /**
     * @return SplFileInfo[]
     */
    private static function findFilesInDirectory(string $directory, string $suffix) : array
    {
        $finder = \RectorPrefix20210103\Symfony\Component\Finder\Finder::create()->in($directory)->files()->name($suffix);
        $fileInfos = \iterator_to_array($finder);
        return \array_values($fileInfos);
    }
}
