<?php

declare (strict_types=1);
namespace RectorPrefix20201230\Symplify\Skipper\SkipVoter;

use RectorPrefix20201230\Symplify\Skipper\Contract\SkipVoterInterface;
use RectorPrefix20201230\Symplify\Skipper\Matcher\FileInfoMatcher;
use RectorPrefix20201230\Symplify\Skipper\SkipCriteriaResolver\SkippedPathsResolver;
use RectorPrefix20201230\Symplify\SmartFileSystem\SmartFileInfo;
final class PathSkipVoter implements \RectorPrefix20201230\Symplify\Skipper\Contract\SkipVoterInterface
{
    /**
     * @var FileInfoMatcher
     */
    private $fileInfoMatcher;
    /**
     * @var SkippedPathsResolver
     */
    private $skippedPathsResolver;
    public function __construct(\RectorPrefix20201230\Symplify\Skipper\Matcher\FileInfoMatcher $fileInfoMatcher, \RectorPrefix20201230\Symplify\Skipper\SkipCriteriaResolver\SkippedPathsResolver $skippedPathsResolver)
    {
        $this->fileInfoMatcher = $fileInfoMatcher;
        $this->skippedPathsResolver = $skippedPathsResolver;
    }
    /**
     * @param string|object $element
     */
    public function match($element) : bool
    {
        return \true;
    }
    /**
     * @param string $element
     */
    public function shouldSkip($element, \RectorPrefix20201230\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        $skippedPaths = $this->skippedPathsResolver->resolve();
        return $this->fileInfoMatcher->doesFileInfoMatchPatterns($smartFileInfo, $skippedPaths);
    }
}
