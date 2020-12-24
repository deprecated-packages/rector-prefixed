<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\Skipper\SkipVoter;

use _PhpScopere8e811afab72\Symplify\Skipper\Contract\SkipVoterInterface;
use _PhpScopere8e811afab72\Symplify\Skipper\Matcher\FileInfoMatcher;
use _PhpScopere8e811afab72\Symplify\Skipper\SkipCriteriaResolver\SkippedClassAndCodesResolver;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * Matching class and code, e.g. App\Category\ArraySniff.SomeCode
 */
final class ClassAndCodeSkipVoter implements \_PhpScopere8e811afab72\Symplify\Skipper\Contract\SkipVoterInterface
{
    /**
     * @var SkippedClassAndCodesResolver
     */
    private $skippedClassAndCodesResolver;
    /**
     * @var FileInfoMatcher
     */
    private $fileInfoMatcher;
    public function __construct(\_PhpScopere8e811afab72\Symplify\Skipper\SkipCriteriaResolver\SkippedClassAndCodesResolver $skippedClassAndCodesResolver, \_PhpScopere8e811afab72\Symplify\Skipper\Matcher\FileInfoMatcher $fileInfoMatcher)
    {
        $this->skippedClassAndCodesResolver = $skippedClassAndCodesResolver;
        $this->fileInfoMatcher = $fileInfoMatcher;
    }
    /**
     * @param string|object $element
     */
    public function match($element) : bool
    {
        if (!\is_string($element)) {
            return \false;
        }
        return \substr_count($element, '.') === 1;
    }
    /**
     * @param string $element
     */
    public function shouldSkip($element, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        $skippedClassAndCodes = $this->skippedClassAndCodesResolver->resolve();
        if (!\array_key_exists($element, $skippedClassAndCodes)) {
            return \false;
        }
        // skip regardless the path
        $skippedPaths = $skippedClassAndCodes[$element];
        if ($skippedPaths === null) {
            return \true;
        }
        return $this->fileInfoMatcher->doesFileInfoMatchPatterns($smartFileInfo, $skippedPaths);
    }
}
