<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\Skipper\SkipCriteriaResolver;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoper0a6b37af0871\Symplify\Skipper\ValueObject\Option;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\Normalizer\PathNormalizer;
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
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\Normalizer\PathNormalizer $pathNormalizer)
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
        $skip = $this->parameterProvider->provideArrayParameter(\_PhpScoper0a6b37af0871\Symplify\Skipper\ValueObject\Option::SKIP);
        foreach ($skip as $key => $value) {
            if (!\is_int($key)) {
                continue;
            }
            if (\file_exists($value)) {
                $this->skippedPaths[] = $this->pathNormalizer->normalizePath($value);
                continue;
            }
            if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::contains($value, '*')) {
                $this->skippedPaths[] = $this->pathNormalizer->normalizePath($value);
                continue;
            }
        }
        return $this->skippedPaths;
    }
}
