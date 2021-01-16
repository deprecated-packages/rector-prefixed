<?php

declare (strict_types=1);
namespace Rector\Composer\ValueObject\ComposerModifier;

use Rector\Composer\Contract\ComposerModifier\ComposerModifierInterface;
use RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
/**
 * @see \Rector\Composer\Tests\ValueObject\ComposerModifier\ChangePackageVersionTest
 */
final class ChangePackageVersion implements \Rector\Composer\Contract\ComposerModifier\ComposerModifierInterface
{
    /**
     * @var string
     */
    private $packageName;
    /**
     * @var string
     */
    private $targetVersion;
    public function __construct(string $packageName, string $targetVersion)
    {
        $this->packageName = $packageName;
        $this->targetVersion = $targetVersion;
    }
    public function modify(\RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson) : void
    {
        $composerJson->changePackageVersion($this->packageName, $this->targetVersion);
    }
}
