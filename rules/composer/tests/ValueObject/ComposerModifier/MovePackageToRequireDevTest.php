<?php

declare (strict_types=1);
namespace Rector\Composer\Tests\ValueObject\ComposerModifier;

use RectorPrefix20210116\PHPUnit\Framework\TestCase;
use Rector\Composer\ValueObject\ComposerModifier\MovePackageToRequireDev;
use RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
final class MovePackageToRequireDevTest extends \RectorPrefix20210116\PHPUnit\Framework\TestCase
{
    public function testMoveNonExistingPackage() : void
    {
        $composerJson = new \RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $expectedComposerJson = new \RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $expectedComposerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $movePackageToRequireDev = new \Rector\Composer\ValueObject\ComposerModifier\MovePackageToRequireDev('vendor1/package3');
        $movePackageToRequireDev->modify($composerJson);
        $this->assertSame($expectedComposerJson->getJsonArray(), $composerJson->getJsonArray());
    }
    public function testMoveExistingPackage() : void
    {
        $composerJson = new \RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $expectedComposerJson = new \RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $expectedComposerJson->setRequire(['vendor1/package2' => '^2.0']);
        $expectedComposerJson->setRequireDev(['vendor1/package1' => '^1.0']);
        $movePackageToRequireDev = new \Rector\Composer\ValueObject\ComposerModifier\MovePackageToRequireDev('vendor1/package1');
        $movePackageToRequireDev->modify($composerJson);
        $this->assertSame($expectedComposerJson->getJsonArray(), $composerJson->getJsonArray());
    }
    public function testMoveExistingDevPackage() : void
    {
        $composerJson = new \RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0']);
        $composerJson->setRequireDev(['vendor1/package2' => '^2.0']);
        $expectedComposerJson = new \RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $expectedComposerJson->setRequire(['vendor1/package1' => '^1.0']);
        $expectedComposerJson->setRequireDev(['vendor1/package2' => '^2.0']);
        $movePackageToRequireDev = new \Rector\Composer\ValueObject\ComposerModifier\MovePackageToRequireDev('vendor1/package2');
        $movePackageToRequireDev->modify($composerJson);
        $this->assertSame($expectedComposerJson->getJsonArray(), $composerJson->getJsonArray());
    }
}
