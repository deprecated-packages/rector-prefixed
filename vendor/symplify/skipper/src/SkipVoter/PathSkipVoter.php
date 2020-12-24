<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\Skipper\SkipVoter;

use _PhpScopere8e811afab72\Symplify\Skipper\Contract\SkipVoterInterface;
use _PhpScopere8e811afab72\Symplify\Skipper\Matcher\FileInfoMatcher;
use _PhpScopere8e811afab72\Symplify\Skipper\SkipCriteriaResolver\SkippedPathsResolver;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class PathSkipVoter implements \_PhpScopere8e811afab72\Symplify\Skipper\Contract\SkipVoterInterface
{
    /**
     * @var FileInfoMatcher
     */
    private $fileInfoMatcher;
    /**
     * @var SkippedPathsResolver
     */
    private $skippedPathsResolver;
    public function __construct(\_PhpScopere8e811afab72\Symplify\Skipper\Matcher\FileInfoMatcher $fileInfoMatcher, \_PhpScopere8e811afab72\Symplify\Skipper\SkipCriteriaResolver\SkippedPathsResolver $skippedPathsResolver)
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
    public function shouldSkip($element, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        $skippedPaths = $this->skippedPathsResolver->resolve();
        return $this->fileInfoMatcher->doesFileInfoMatchPatterns($smartFileInfo, $skippedPaths);
    }
}
