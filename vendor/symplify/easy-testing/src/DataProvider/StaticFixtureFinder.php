<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\EasyTesting\DataProvider;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Finder\Finder;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Finder\SplFileInfo;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class StaticFixtureFinder
{
    public static function yieldDirectory(string $directory, string $suffix = '*.php.inc') : \Iterator
    {
        $fileInfos = self::findFilesInDirectory($directory, $suffix);
        foreach ($fileInfos as $fileInfo) {
            (yield [new \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo($fileInfo->getRealPath())]);
        }
    }
    /**
     * @return SplFileInfo[]
     */
    private static function findFilesInDirectory(string $directory, string $suffix) : array
    {
        $finder = \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Finder\Finder::create()->in($directory)->files()->name($suffix);
        $fileInfos = \iterator_to_array($finder);
        return \array_values($fileInfos);
    }
}
