<?php

declare (strict_types=1);
namespace Rector\Composer\Rector;

use Rector\Composer\Contract\Rector\ComposerRectorInterface;
use RectorPrefix20210423\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\Composer\Rector\RemovePackageComposerRector\RemovePackageComposerRectorTest
 */
final class RemovePackageComposerRector implements \Rector\Composer\Contract\Rector\ComposerRectorInterface
{
    /**
     * @var string
     */
    const PACKAGE_NAMES = 'package_names';
    /**
     * @var string[]
     */
    private $packageNames = [];
    /**
     * @return void
     */
    public function refactor(\RectorPrefix20210423\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson)
    {
        foreach ($this->packageNames as $packageName) {
            $composerJson->removePackage($packageName);
        }
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove package from "require" and "require-dev" in `composer.json`', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
{
    "require": {
        "symfony/console": "^3.4"
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
{
}
CODE_SAMPLE
, [self::PACKAGE_NAMES => ['symfony/console']])]);
    }
    /**
     * @param array<string, string[]> $configuration
     * @return void
     */
    public function configure(array $configuration)
    {
        $this->packageNames = $configuration[self::PACKAGE_NAMES] ?? [];
    }
}
