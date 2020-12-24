<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\EasyTesting\DataProvider;

use Iterator;
use _PhpScoper0a6b37af0871\Symfony\Component\Finder\Finder;
use _PhpScoper0a6b37af0871\Symfony\Component\Finder\SplFileInfo;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class StaticFixtureFinder
{
    public static function yieldDirectory(string $directory, string $suffix = '*.php.inc') : \Iterator
    {
        $fileInfos = self::findFilesInDirectory($directory, $suffix);
        foreach ($fileInfos as $fileInfo) {
            (yield [new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo($fileInfo->getRealPath())]);
        }
    }
    /**
     * @return SplFileInfo[]
     */
    private static function findFilesInDirectory(string $directory, string $suffix) : array
    {
        $finder = \_PhpScoper0a6b37af0871\Symfony\Component\Finder\Finder::create()->in($directory)->files()->name($suffix);
        $fileInfos = \iterator_to_array($finder);
        return \array_values($fileInfos);
    }
}
