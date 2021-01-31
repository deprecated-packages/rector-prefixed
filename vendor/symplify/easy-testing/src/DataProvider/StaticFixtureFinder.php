<?php

declare (strict_types=1);
namespace RectorPrefix20210131\Symplify\EasyTesting\DataProvider;

use Iterator;
use RectorPrefix20210131\Symfony\Component\Finder\Finder;
use RectorPrefix20210131\Symfony\Component\Finder\SplFileInfo;
use RectorPrefix20210131\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210131\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class StaticFixtureFinder
{
    public static function yieldDirectory(string $directory, string $suffix = '*.php.inc') : \Iterator
    {
        $fileInfos = self::findFilesInDirectory($directory, $suffix);
        foreach ($fileInfos as $fileInfo) {
            (yield [new \RectorPrefix20210131\Symplify\SmartFileSystem\SmartFileInfo($fileInfo->getRealPath())]);
        }
    }
    public static function yieldDirectoryExclusively(string $directory, string $suffix = '*.php.inc') : \Iterator
    {
        $fileInfos = self::findFilesInDirectoryExclusively($directory, $suffix);
        foreach ($fileInfos as $fileInfo) {
            (yield [new \RectorPrefix20210131\Symplify\SmartFileSystem\SmartFileInfo($fileInfo->getRealPath())]);
        }
    }
    /**
     * @return SplFileInfo[]
     */
    private static function findFilesInDirectory(string $directory, string $suffix) : array
    {
        $finder = \RectorPrefix20210131\Symfony\Component\Finder\Finder::create()->in($directory)->files()->name($suffix);
        $fileInfos = \iterator_to_array($finder);
        $finderAll = \RectorPrefix20210131\Symfony\Component\Finder\Finder::create()->in($directory)->files();
        foreach ($finderAll as $key => $fileInfoAll) {
            $fileNameFromAll = $fileInfoAll->getFileName();
            if (!isset($fileInfos[$key])) {
                throw new \RectorPrefix20210131\Symplify\SymplifyKernel\Exception\ShouldNotHappenException(\sprintf('"%s" has invalid suffix, use "%s" suffix instead', $fileNameFromAll, $suffix));
            }
        }
        return \array_values($fileInfos);
    }
    /**
     * @return SplFileInfo[]
     */
    private static function findFilesInDirectoryExclusively(string $directory, string $suffix) : array
    {
        $finder = \RectorPrefix20210131\Symfony\Component\Finder\Finder::create()->in($directory)->files()->name($suffix);
        $fileInfos = \iterator_to_array($finder);
        return \array_values($fileInfos);
    }
}
