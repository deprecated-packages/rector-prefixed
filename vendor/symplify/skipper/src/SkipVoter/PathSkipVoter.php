<?php

declare (strict_types=1);
namespace RectorPrefix20210317\Symplify\Skipper\SkipVoter;

use RectorPrefix20210317\Symplify\Skipper\Contract\SkipVoterInterface;
use RectorPrefix20210317\Symplify\Skipper\Matcher\FileInfoMatcher;
use RectorPrefix20210317\Symplify\Skipper\SkipCriteriaResolver\SkippedPathsResolver;
use RectorPrefix20210317\Symplify\SmartFileSystem\SmartFileInfo;
final class PathSkipVoter implements \RectorPrefix20210317\Symplify\Skipper\Contract\SkipVoterInterface
{
    /**
     * @var FileInfoMatcher
     */
    private $fileInfoMatcher;
    /**
     * @var SkippedPathsResolver
     */
    private $skippedPathsResolver;
    /**
     * @param \Symplify\Skipper\Matcher\FileInfoMatcher $fileInfoMatcher
     * @param \Symplify\Skipper\SkipCriteriaResolver\SkippedPathsResolver $skippedPathsResolver
     */
    public function __construct($fileInfoMatcher, $skippedPathsResolver)
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
    public function shouldSkip($element, \RectorPrefix20210317\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        $skippedPaths = $this->skippedPathsResolver->resolve();
        return $this->fileInfoMatcher->doesFileInfoMatchPatterns($smartFileInfo, $skippedPaths);
    }
}
