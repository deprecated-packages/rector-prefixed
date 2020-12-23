<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\Skipper\SkipVoter;

use _PhpScoper0a2ac50786fa\Symplify\Skipper\Contract\SkipVoterInterface;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\Matcher\FileInfoMatcher;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\SkipCriteriaResolver\SkippedPathsResolver;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class PathSkipVoter implements \_PhpScoper0a2ac50786fa\Symplify\Skipper\Contract\SkipVoterInterface
{
    /**
     * @var FileInfoMatcher
     */
    private $fileInfoMatcher;
    /**
     * @var SkippedPathsResolver
     */
    private $skippedPathsResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Symplify\Skipper\Matcher\FileInfoMatcher $fileInfoMatcher, \_PhpScoper0a2ac50786fa\Symplify\Skipper\SkipCriteriaResolver\SkippedPathsResolver $skippedPathsResolver)
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
    public function shouldSkip($element, \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        $skippedPaths = $this->skippedPathsResolver->resolve();
        return $this->fileInfoMatcher->doesFileInfoMatchPatterns($smartFileInfo, $skippedPaths);
    }
}
