<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\Skipper\SkipVoter;

use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\Contract\SkipVoterInterface;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\SkipCriteriaResolver\SkippedClassResolver;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\Skipper\OnlySkipper;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\Skipper\SkipSkipper;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\ValueObject\Option;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class ClassSkipVoter implements \_PhpScoper0a2ac50786fa\Symplify\Skipper\Contract\SkipVoterInterface
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
    public function __construct(\_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker $classLikeExistenceChecker, \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \_PhpScoper0a2ac50786fa\Symplify\Skipper\Skipper\SkipSkipper $skipSkipper, \_PhpScoper0a2ac50786fa\Symplify\Skipper\Skipper\OnlySkipper $onlySkipper, \_PhpScoper0a2ac50786fa\Symplify\Skipper\SkipCriteriaResolver\SkippedClassResolver $skippedClassResolver)
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
    public function shouldSkip($element, \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        $only = $this->parameterProvider->provideArrayParameter(\_PhpScoper0a2ac50786fa\Symplify\Skipper\ValueObject\Option::ONLY);
        $doesMatchOnly = $this->onlySkipper->doesMatchOnly($element, $smartFileInfo, $only);
        if (\is_bool($doesMatchOnly)) {
            return $doesMatchOnly;
        }
        $skippedClasses = $this->skippedClassResolver->resolve();
        return $this->skipSkipper->doesMatchSkip($element, $smartFileInfo, $skippedClasses);
    }
}
