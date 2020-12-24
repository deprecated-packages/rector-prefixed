<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\Skipper\SkipCriteriaResolver;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoperb75b35f52b74\Symplify\Skipper\ValueObject\Option;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Normalizer\PathNormalizer;
/**
 * @see \Symplify\Skipper\Tests\SkipCriteriaResolver\SkippedPathsResolver\SkippedPathsResolverTest
 */
final class SkippedPathsResolver
{
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    /**
     * @var string[]
     */
    private $skippedPaths = [];
    /**
     * @var PathNormalizer
     */
    private $pathNormalizer;
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Normalizer\PathNormalizer $pathNormalizer)
    {
        $this->parameterProvider = $parameterProvider;
        $this->pathNormalizer = $pathNormalizer;
    }
    /**
     * @return string[]
     */
    public function resolve() : array
    {
        if ($this->skippedPaths !== []) {
            return $this->skippedPaths;
        }
        $skip = $this->parameterProvider->provideArrayParameter(\_PhpScoperb75b35f52b74\Symplify\Skipper\ValueObject\Option::SKIP);
        foreach ($skip as $key => $value) {
            if (!\is_int($key)) {
                continue;
            }
            if (\file_exists($value)) {
                $this->skippedPaths[] = $this->pathNormalizer->normalizePath($value);
                continue;
            }
            if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($value, '*')) {
                $this->skippedPaths[] = $this->pathNormalizer->normalizePath($value);
                continue;
            }
        }
        return $this->skippedPaths;
    }
}
