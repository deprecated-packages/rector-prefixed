<?php

declare (strict_types=1);
namespace Rector\Composer\ValueObject\ComposerModifier;

use Rector\Composer\Contract\ComposerModifier\ComposerModifierInterface;
use RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
/**
 * Moves package to require-dev section, if package is not in composer data, nothing happen, also if package is already in require-dev section
 * @see \Rector\Composer\Tests\ValueObject\ComposerModifier\MovePackageToRequireDevTest
 */
final class MovePackageToRequireDev implements \Rector\Composer\Contract\ComposerModifier\ComposerModifierInterface
{
    /** @var string */
    private $packageName;
    /**
     * @param string $packageName name of package to be moved (vendor/package)
     */
    public function __construct(string $packageName)
    {
        $this->packageName = $packageName;
    }
    public function modify(\RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson) : \RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson
    {
        $composerJson->movePackageToRequireDev($this->packageName);
        return $composerJson;
    }
}
