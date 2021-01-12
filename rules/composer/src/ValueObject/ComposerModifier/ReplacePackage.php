<?php

declare (strict_types=1);
namespace Rector\Composer\ValueObject\ComposerModifier;

use Rector\Composer\Contract\ComposerModifier\ComposerModifierInterface;
use Rector\Composer\ValueObject\Version\Version;
use RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use RectorPrefix20210112\Webmozart\Assert\Assert;
/**
 * Replace one package for another
 * @see \Rector\Composer\Tests\ValueObject\ComposerModifier\ReplacePackageTest
 */
final class ReplacePackage implements \Rector\Composer\Contract\ComposerModifier\ComposerModifierInterface
{
    /** @var string */
    private $oldPackageName;
    /** @var string */
    private $newPackageName;
    /** @var Version */
    private $targetVersion;
    /**
     * @param string $oldPackageName name of package to be replaced (vendor1/package1)
     * @param string $newPackageName new name of package (vendor2/package2)
     * @param string $targetVersion target package version (1.2.3, ^1.2, ~1.2.3 etc.)
     */
    public function __construct(string $oldPackageName, string $newPackageName, string $targetVersion)
    {
        \RectorPrefix20210112\Webmozart\Assert\Assert::notSame($oldPackageName, $newPackageName, '$oldPackageName cannot be the same as $newPackageName. If you want to change version of package, use ' . \Rector\Composer\ValueObject\ComposerModifier\ChangePackageVersion::class);
        $this->oldPackageName = $oldPackageName;
        $this->newPackageName = $newPackageName;
        $this->targetVersion = new \Rector\Composer\ValueObject\Version\Version($targetVersion);
    }
    public function modify(\RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson) : \RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson
    {
        $composerJson->replacePackage($this->oldPackageName, $this->newPackageName, $this->targetVersion->getVersion());
        return $composerJson;
    }
}
