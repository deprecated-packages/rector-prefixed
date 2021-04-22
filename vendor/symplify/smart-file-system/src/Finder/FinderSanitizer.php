<?php

declare (strict_types=1);
namespace RectorPrefix20210422\Symplify\SmartFileSystem\Finder;

use RectorPrefix20210422\Nette\Utils\Finder as NetteFinder;
use SplFileInfo;
use RectorPrefix20210422\Symfony\Component\Finder\Finder as SymfonyFinder;
use RectorPrefix20210422\Symfony\Component\Finder\SplFileInfo as SymfonySplFileInfo;
use RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\SmartFileSystem\Tests\Finder\FinderSanitizer\FinderSanitizerTest
 */
final class FinderSanitizer
{
    /**
     * @param mixed[] $files
     * @return SmartFileInfo[]
     */
    public function sanitize($files) : array
    {
        $smartFileInfos = [];
        foreach ($files as $file) {
            $fileInfo = \is_string($file) ? new \SplFileInfo($file) : $file;
            if (!$this->isFileInfoValid($fileInfo)) {
                continue;
            }
            /** @var string $realPath */
            $realPath = $fileInfo->getRealPath();
            $smartFileInfos[] = new \RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileInfo($realPath);
        }
        return $smartFileInfos;
    }
    private function isFileInfoValid(\SplFileInfo $fileInfo) : bool
    {
        return (bool) $fileInfo->getRealPath();
    }
}
