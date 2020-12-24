<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\Skipper\SkipVoter;

use _PhpScoperb75b35f52b74\Symplify\Skipper\Contract\SkipVoterInterface;
use _PhpScoperb75b35f52b74\Symplify\Skipper\Matcher\FileInfoMatcher;
use _PhpScoperb75b35f52b74\Symplify\Skipper\SkipCriteriaResolver\SkippedPathsResolver;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class PathSkipVoter implements \_PhpScoperb75b35f52b74\Symplify\Skipper\Contract\SkipVoterInterface
{
    /**
     * @var FileInfoMatcher
     */
    private $fileInfoMatcher;
    /**
     * @var SkippedPathsResolver
     */
    private $skippedPathsResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\Skipper\Matcher\FileInfoMatcher $fileInfoMatcher, \_PhpScoperb75b35f52b74\Symplify\Skipper\SkipCriteriaResolver\SkippedPathsResolver $skippedPathsResolver)
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
    public function shouldSkip($element, \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        $skippedPaths = $this->skippedPathsResolver->resolve();
        return $this->fileInfoMatcher->doesFileInfoMatchPatterns($smartFileInfo, $skippedPaths);
    }
}
