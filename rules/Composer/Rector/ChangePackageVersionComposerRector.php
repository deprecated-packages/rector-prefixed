<?php

declare(strict_types=1);

namespace Rector\Composer\Rector;

use Rector\Composer\Contract\Rector\ComposerRectorInterface;
use Rector\Composer\Guard\VersionGuard;
use Rector\Composer\ValueObject\PackageAndVersion;
use Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\Composer\Rector\ChangePackageVersionComposerRector\ChangePackageVersionComposerRectorTest
 */
final class ChangePackageVersionComposerRector implements ComposerRectorInterface
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

    public function __construct(VersionGuard $versionGuard)
    {
        $this->versionGuard = $versionGuard;
    }

    /**
     * @return void
     */
    public function refactor(ComposerJson $composerJson)
    {
        foreach ($this->packagesAndVersions as $packageAndVersion) {
            $composerJson->changePackageVersion(
                $packageAndVersion->getPackageName(),
                $packageAndVersion->getVersion()
            );
        }
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Change package version `composer.json`', [new ConfiguredCodeSample(
            <<<'CODE_SAMPLE'
{
    "require-dev": {
        "symfony/console": "^3.4"
    }
}
CODE_SAMPLE
            ,
            <<<'CODE_SAMPLE'
{
    "require": {
        "symfony/console": "^4.4"
    }
}
CODE_SAMPLE
            , [
                self::PACKAGES_AND_VERSIONS => [new PackageAndVersion('symfony/console', '^4.4')],
            ]
        ),
        ]);
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
