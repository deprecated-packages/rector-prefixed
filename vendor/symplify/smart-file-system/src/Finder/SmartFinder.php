<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\Finder;

use _PhpScoper0a6b37af0871\Symfony\Component\Finder\Finder;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\FileSystemFilter;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\SmartFileSystem\Tests\Finder\SmartFinder\SmartFinderTest
 */
final class SmartFinder
{
    /**
     * @var FinderSanitizer
     */
    private $finderSanitizer;
    /**
     * @var FileSystemFilter
     */
    private $fileSystemFilter;
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\Finder\FinderSanitizer $finderSanitizer, \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\FileSystemFilter $fileSystemFilter)
    {
        $this->finderSanitizer = $finderSanitizer;
        $this->fileSystemFilter = $fileSystemFilter;
    }
    /**
     * @param string[] $excludedDirectories
     * @return SmartFileInfo[]
     */
    public function find(array $directoriesOrFiles, string $name, array $excludedDirectories = []) : array
    {
        $directories = $this->fileSystemFilter->filterDirectories($directoriesOrFiles);
        $fileInfos = [];
        if (\count($directories) > 0) {
            $finder = new \_PhpScoper0a6b37af0871\Symfony\Component\Finder\Finder();
            $finder->name($name)->in($directories)->files()->sortByName();
            if ($excludedDirectories !== []) {
                $finder->exclude($excludedDirectories);
            }
            $fileInfos = $this->finderSanitizer->sanitize($finder);
        }
        $files = $this->fileSystemFilter->filterFiles($directoriesOrFiles);
        foreach ($files as $file) {
            $fileInfos[] = new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo($file);
        }
        return $fileInfos;
    }
}
