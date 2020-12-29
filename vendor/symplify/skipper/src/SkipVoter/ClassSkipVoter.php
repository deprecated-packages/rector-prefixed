<?php

declare (strict_types=1);
namespace RectorPrefix20201229\Symplify\Skipper\SkipVoter;

use RectorPrefix20201229\Symplify\PackageBuilder\Parameter\ParameterProvider;
use RectorPrefix20201229\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use RectorPrefix20201229\Symplify\Skipper\Contract\SkipVoterInterface;
use RectorPrefix20201229\Symplify\Skipper\SkipCriteriaResolver\SkippedClassResolver;
use RectorPrefix20201229\Symplify\Skipper\Skipper\OnlySkipper;
use RectorPrefix20201229\Symplify\Skipper\Skipper\SkipSkipper;
use RectorPrefix20201229\Symplify\Skipper\ValueObject\Option;
use RectorPrefix20201229\Symplify\SmartFileSystem\SmartFileInfo;
final class ClassSkipVoter implements \RectorPrefix20201229\Symplify\Skipper\Contract\SkipVoterInterface
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
    public function __construct(\RectorPrefix20201229\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker $classLikeExistenceChecker, \RectorPrefix20201229\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \RectorPrefix20201229\Symplify\Skipper\Skipper\SkipSkipper $skipSkipper, \RectorPrefix20201229\Symplify\Skipper\Skipper\OnlySkipper $onlySkipper, \RectorPrefix20201229\Symplify\Skipper\SkipCriteriaResolver\SkippedClassResolver $skippedClassResolver)
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
    public function shouldSkip($element, \RectorPrefix20201229\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        $only = $this->parameterProvider->provideArrayParameter(\RectorPrefix20201229\Symplify\Skipper\ValueObject\Option::ONLY);
        $doesMatchOnly = $this->onlySkipper->doesMatchOnly($element, $smartFileInfo, $only);
        if (\is_bool($doesMatchOnly)) {
            return $doesMatchOnly;
        }
        $skippedClasses = $this->skippedClassResolver->resolve();
        return $this->skipSkipper->doesMatchSkip($element, $smartFileInfo, $skippedClasses);
    }
}
