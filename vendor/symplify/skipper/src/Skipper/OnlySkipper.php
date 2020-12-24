<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\Skipper\Skipper;

use _PhpScoper0a6b37af0871\Symplify\Skipper\Matcher\FileInfoMatcher;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\Skipper\Tests\Skipper\Only\OnlySkipperTest
 */
final class OnlySkipper
{
    /**
     * @var FileInfoMatcher
     */
    private $fileInfoMatcher;
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\Skipper\Matcher\FileInfoMatcher $fileInfoMatcher)
    {
        $this->fileInfoMatcher = $fileInfoMatcher;
    }
    /**
     * @param object|string $checker
     * @param mixed[] $only
     */
    public function doesMatchOnly($checker, \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, array $only) : ?bool
    {
        foreach ($only as $onlyClass => $onlyFiles) {
            if (\is_int($onlyClass)) {
                // solely class
                $onlyClass = $onlyFiles;
                $onlyFiles = null;
            }
            if (!\is_a($checker, $onlyClass, \true)) {
                continue;
            }
            if ($onlyFiles === null) {
                return \true;
            }
            return !$this->fileInfoMatcher->doesFileInfoMatchPatterns($smartFileInfo, $onlyFiles);
        }
        return null;
    }
}
