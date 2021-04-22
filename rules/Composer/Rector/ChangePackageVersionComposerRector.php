<?php

declare (strict_types=1);
namespace Rector\Composer\Rector;

use Rector\Composer\Contract\Rector\ComposerRectorInterface;
use Rector\Composer\Guard\VersionGuard;
use Rector\Composer\ValueObject\PackageAndVersion;
use RectorPrefix20210422\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\Composer\Rector\ChangePackageVersionComposerRector\ChangePackageVersionComposerRectorTest
 */
final class ChangePackageVersionComposerRector implements \Rector\Composer\Contract\Rector\ComposerRectorInterface
{
    /**
     * @var string
     */
    const PACKAGES_AND_VERSIONS = 'packages_and_versions';
    /**
     * @var PackageAndVersion[]
     */
    private $packagesAndVersions = [];
    /**
     * @var VersionGuard
     */
    private $versionGuard;
    public function __construct(\Rector\Composer\Guard\VersionGuard $versionGuard)
    {
        $this->versionGuard = $versionGuard;
    }
    /**
     * @return void
     */
    public function refactor(\RectorPrefix20210422\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson)
    {
        foreach ($this->packagesAndVersions as $packageAndVersion) {
            $composerJson->changePackageVersion($packageAndVersion->getPackageName(), $packageAndVersion->getVersion());
        }
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change package version `composer.json`', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
{
    "require-dev": {
        "symfony/console": "^3.4"
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
{
    "require": {
        "symfony/console": "^4.4"
    }
}
CODE_SAMPLE
, [self::PACKAGES_AND_VERSIONS => [new \Rector\Composer\ValueObject\PackageAndVersion('symfony/console', '^4.4')]])]);
    }
    /**
     * @param array<string, PackageAndVersion[]> $configuration
     * @return void
     */
    public function configure(array $configuration)
    {
        $packagesAndVersions = $configuration[self::PACKAGES_AND_VERSIONS] ?? [];
        $this->versionGuard->validate($packagesAndVersions);
        $this->packagesAndVersions = $packagesAndVersions;
    }
}
