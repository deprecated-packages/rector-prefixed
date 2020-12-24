<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\File;

use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Symfony\Component\Finder\Finder;
class FileFinder
{
    /** @var FileExcluder */
    private $fileExcluder;
    /** @var FileHelper */
    private $fileHelper;
    /** @var string[] */
    private $fileExtensions;
    /**
     * @param FileExcluder $fileExcluder
     * @param FileHelper $fileHelper
     * @param string[] $fileExtensions
     */
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\File\FileExcluder $fileExcluder, \_PhpScoper0a6b37af0871\PHPStan\File\FileHelper $fileHelper, array $fileExtensions)
    {
        $this->fileExcluder = $fileExcluder;
        $this->fileHelper = $fileHelper;
        $this->fileExtensions = $fileExtensions;
    }
    /**
     * @param string[] $paths
     * @return FileFinderResult
     */
    public function findFiles(array $paths) : \_PhpScoper0a6b37af0871\PHPStan\File\FileFinderResult
    {
        $onlyFiles = \true;
        $files = [];
        foreach ($paths as $path) {
            if (!\file_exists($path)) {
                throw new \_PhpScoper0a6b37af0871\PHPStan\File\PathNotFoundException($path);
            } elseif (\is_file($path)) {
                $files[] = $this->fileHelper->normalizePath($path);
            } else {
                $finder = new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Symfony\Component\Finder\Finder();
                $finder->followLinks();
                foreach ($finder->files()->name('*.{' . \implode(',', $this->fileExtensions) . '}')->in($path) as $fileInfo) {
                    $files[] = $this->fileHelper->normalizePath($fileInfo->getPathname());
                    $onlyFiles = \false;
                }
            }
        }
        $files = \array_values(\array_filter($files, function (string $file) : bool {
            return !$this->fileExcluder->isExcludedFromAnalysing($file);
        }));
        return new \_PhpScoper0a6b37af0871\PHPStan\File\FileFinderResult($files, $onlyFiles);
    }
}
