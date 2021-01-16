<?php

declare (strict_types=1);
namespace Rector\Composer\ValueObject\ComposerModifier;

use Rector\Composer\Contract\ComposerModifier\ComposerModifierInterface;
use RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use RectorPrefix20210116\Webmozart\Assert\Assert;
/**
 * Replace one package for another
 * @see \Rector\Composer\Tests\ValueObject\ComposerModifier\ReplacePackageTest
 */
final class ReplacePackage implements \Rector\Composer\Contract\ComposerModifier\ComposerModifierInterface
{
    /**
     * @var string
     */
    private $oldPackageName;
    /**
     * @var string
     */
    private $newPackageName;
    /**
     * @var string
     */
    private $targetVersion;
    public function __construct(string $oldPackageName, string $newPackageName, string $targetVersion)
    {
        \RectorPrefix20210116\Webmozart\Assert\Assert::notSame($oldPackageName, $newPackageName, '$oldPackageName cannot be the same as $newPackageName. If you want to change version of package, use ' . \Rector\Composer\ValueObject\ComposerModifier\ChangePackageVersion::class);
        $this->oldPackageName = $oldPackageName;
        $this->newPackageName = $newPackageName;
        $this->targetVersion = $targetVersion;
    }
    public function modify(\RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson) : void
    {
        $composerJson->replacePackage($this->oldPackageName, $this->newPackageName, $this->targetVersion);
    }
}
