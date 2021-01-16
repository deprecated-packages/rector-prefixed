<?php

declare (strict_types=1);
namespace Rector\Composer\ValueObject\ComposerModifier;

use Rector\Composer\Contract\ComposerModifier\ComposerModifierInterface;
use RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
/**
 * Removes package from composer data
 * @see \Rector\Composer\Tests\ValueObject\ComposerModifier\RemovePackageTest
 */
final class RemovePackage implements \Rector\Composer\Contract\ComposerModifier\ComposerModifierInterface
{
    /**
     * @var string
     */
    private $packageName;
    public function __construct(string $packageName)
    {
        $this->packageName = $packageName;
    }
    public function modify(\RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson) : void
    {
        $composerJson->removePackage($this->packageName);
    }
}
