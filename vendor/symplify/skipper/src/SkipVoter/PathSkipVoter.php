<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\Skipper\SkipVoter;

use _PhpScoper2a4e7ab1ecbc\Symplify\Skipper\Contract\SkipVoterInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\Skipper\Matcher\FileInfoMatcher;
use _PhpScoper2a4e7ab1ecbc\Symplify\Skipper\SkipCriteriaResolver\SkippedPathsResolver;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class PathSkipVoter implements \_PhpScoper2a4e7ab1ecbc\Symplify\Skipper\Contract\SkipVoterInterface
{
    /**
     * @var FileInfoMatcher
     */
    private $fileInfoMatcher;
    /**
     * @var SkippedPathsResolver
     */
    private $skippedPathsResolver;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Symplify\Skipper\Matcher\FileInfoMatcher $fileInfoMatcher, \_PhpScoper2a4e7ab1ecbc\Symplify\Skipper\SkipCriteriaResolver\SkippedPathsResolver $skippedPathsResolver)
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
    public function shouldSkip($element, \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        $skippedPaths = $this->skippedPathsResolver->resolve();
        return $this->fileInfoMatcher->doesFileInfoMatchPatterns($smartFileInfo, $skippedPaths);
    }
}
