<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\Skipper\SkipVoter;

use _PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use _PhpScopere8e811afab72\Symplify\Skipper\Contract\SkipVoterInterface;
use _PhpScopere8e811afab72\Symplify\Skipper\SkipCriteriaResolver\SkippedClassResolver;
use _PhpScopere8e811afab72\Symplify\Skipper\Skipper\OnlySkipper;
use _PhpScopere8e811afab72\Symplify\Skipper\Skipper\SkipSkipper;
use _PhpScopere8e811afab72\Symplify\Skipper\ValueObject\Option;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ClassSkipVoter implements \_PhpScopere8e811afab72\Symplify\Skipper\Contract\SkipVoterInterface
{
    /**
     * @var ClassLikeExistenceChecker
     */
    private $classLikeExistenceChecker;
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    /**
     * @var SkipSkipper
     */
    private $skipSkipper;
    /**
     * @var OnlySkipper
     */
    private $onlySkipper;
    /**
     * @var SkippedClassResolver
     */
    private $skippedClassResolver;
    public function __construct(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker $classLikeExistenceChecker, \_PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \_PhpScopere8e811afab72\Symplify\Skipper\Skipper\SkipSkipper $skipSkipper, \_PhpScopere8e811afab72\Symplify\Skipper\Skipper\OnlySkipper $onlySkipper, \_PhpScopere8e811afab72\Symplify\Skipper\SkipCriteriaResolver\SkippedClassResolver $skippedClassResolver)
    {
        $this->classLikeExistenceChecker = $classLikeExistenceChecker;
        $this->parameterProvider = $parameterProvider;
        $this->skipSkipper = $skipSkipper;
        $this->onlySkipper = $onlySkipper;
        $this->skippedClassResolver = $skippedClassResolver;
    }
    /**
     * @param string|object $element
     */
    public function match($element) : bool
    {
        if (\is_object($element)) {
            return \true;
        }
        return $this->classLikeExistenceChecker->doesClassLikeExist($element);
    }
    /**
     * @param string|object $element
     */
    public function shouldSkip($element, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        $only = $this->parameterProvider->provideArrayParameter(\_PhpScopere8e811afab72\Symplify\Skipper\ValueObject\Option::ONLY);
        $doesMatchOnly = $this->onlySkipper->doesMatchOnly($element, $smartFileInfo, $only);
        if (\is_bool($doesMatchOnly)) {
            return $doesMatchOnly;
        }
        $skippedClasses = $this->skippedClassResolver->resolve();
        return $this->skipSkipper->doesMatchSkip($element, $smartFileInfo, $skippedClasses);
    }
}
