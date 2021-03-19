<?php

declare (strict_types=1);
namespace Rector\Core\Php;

use Rector\Core\Configuration\Option;
use Rector\Core\Php\PhpVersionResolver\ProjectComposerJsonPhpVersionResolver;
use Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use RectorPrefix20210319\Symplify\PackageBuilder\Parameter\ParameterProvider;
/**
 * @see \Rector\Core\Tests\Php\PhpVersionProviderTest
 */
final class PhpVersionProvider
{
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    /**
     * @var ProjectComposerJsonPhpVersionResolver
     */
    private $projectComposerJsonPhpVersionResolver;
    public function __construct(\RectorPrefix20210319\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \Rector\Core\Php\PhpVersionResolver\ProjectComposerJsonPhpVersionResolver $projectComposerJsonPhpVersionResolver)
    {
        $this->parameterProvider = $parameterProvider;
        $this->projectComposerJsonPhpVersionResolver = $projectComposerJsonPhpVersionResolver;
    }
    public function provide() : int
    {
        /** @var int|null $phpVersionFeatures */
        $phpVersionFeatures = $this->parameterProvider->provideParameter(\Rector\Core\Configuration\Option::PHP_VERSION_FEATURES);
        if ($phpVersionFeatures !== null) {
            return $phpVersionFeatures;
        }
        // for tests
        if (\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            // so we don't have to up
            return 100000;
        }
        $projectComposerJson = \getcwd() . '/composer.json';
        if (\file_exists($projectComposerJson)) {
            $phpVersion = $this->projectComposerJsonPhpVersionResolver->resolve($projectComposerJson);
            if ($phpVersion !== null) {
                return $phpVersion;
            }
        }
        return \PHP_VERSION_ID;
    }
    public function isAtLeastPhpVersion(int $phpVersion) : bool
    {
        return $phpVersion <= $this->provide();
    }
}
