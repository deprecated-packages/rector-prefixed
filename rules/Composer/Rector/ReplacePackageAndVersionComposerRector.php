<?php

declare (strict_types=1);
namespace Rector\Composer\Rector;

use Rector\Composer\Contract\Rector\ComposerRectorInterface;
use Rector\Composer\Guard\VersionGuard;
use Rector\Composer\ValueObject\ReplacePackageAndVersion;
use RectorPrefix20210408\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\Composer\Rector\ReplacePackageAndVersionComposerRector\ReplacePackageAndVersionComposerRectorTest
 */
final class ReplacePackageAndVersionComposerRector implements \Rector\Composer\Contract\Rector\ComposerRectorInterface
{
    /**
     * @var string
     */
    public const REPLACE_PACKAGES_AND_VERSIONS = 'replace_packages_and_versions';
    /**
     * @var ReplacePackageAndVersion[]
     */
    private $replacePackagesAndVersions = [];
    /**
     * @var VersionGuard
     */
    private $versionGuard;
    public function __construct(\Rector\Composer\Guard\VersionGuard $versionGuard)
    {
        $this->versionGuard = $versionGuard;
    }
    public function refactor(\RectorPrefix20210408\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson) : void
    {
        foreach ($this->replacePackagesAndVersions as $replacePackageAndVersion) {
            $composerJson->replacePackage($replacePackageAndVersion->getOldPackageName(), $replacePackageAndVersion->getNewPackageName(), $replacePackageAndVersion->getVersion());
        }
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change package name and version `composer.json`', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
{
    "require-dev": {
        "symfony/console": "^3.4"
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
{
    "require-dev": {
        "symfony/http-kernel": "^4.4"
    }
}
CODE_SAMPLE
, [self::REPLACE_PACKAGES_AND_VERSIONS => [new \Rector\Composer\ValueObject\ReplacePackageAndVersion('symfony/console', 'symfony/http-kernel', '^4.4')]])]);
    }
    /**
     * @param array<string, ReplacePackageAndVersion[]> $configuration
     */
    public function configure(array $configuration) : void
    {
        $replacePackagesAndVersions = $configuration[self::REPLACE_PACKAGES_AND_VERSIONS] ?? [];
        $this->versionGuard->validate($replacePackagesAndVersions);
        $this->replacePackagesAndVersions = $replacePackagesAndVersions;
    }
}
