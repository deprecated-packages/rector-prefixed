<?php

namespace Rector\Composer\Tests\ValueObject\ComposerModifier;

use RectorPrefix20210112\PHPUnit\Framework\TestCase;
use Rector\Composer\ValueObject\ComposerModifier\MovePackageToRequireDev;
use RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
final class MovePackageToRequireDevTest extends \RectorPrefix20210112\PHPUnit\Framework\TestCase
{
    public function testMoveNonExistingPackage() : void
    {
        $composerJson = new \RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $changedComposerJson = new \RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $changedComposerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $movePackageToRequireDev = new \Rector\Composer\ValueObject\ComposerModifier\MovePackageToRequireDev('vendor1/package3');
        $this->assertEquals($changedComposerJson, $movePackageToRequireDev->modify($composerJson));
    }
    public function testMoveExistingPackage() : void
    {
        $composerJson = new \RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $changedComposerJson = new \RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $changedComposerJson->setRequire(['vendor1/package2' => '^2.0']);
        $changedComposerJson->setRequireDev(['vendor1/package1' => '^1.0']);
        $movePackageToRequireDev = new \Rector\Composer\ValueObject\ComposerModifier\MovePackageToRequireDev('vendor1/package1');
        $this->assertEquals($changedComposerJson, $movePackageToRequireDev->modify($composerJson));
    }
    public function testMoveExistingDevPackage() : void
    {
        $composerJson = new \RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0']);
        $composerJson->setRequireDev(['vendor1/package2' => '^2.0']);
        $changedComposerJson = new \RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $changedComposerJson->setRequire(['vendor1/package1' => '^1.0']);
        $changedComposerJson->setRequireDev(['vendor1/package2' => '^2.0']);
        $movePackageToRequireDev = new \Rector\Composer\ValueObject\ComposerModifier\MovePackageToRequireDev('vendor1/package2');
        $this->assertEquals($changedComposerJson, $movePackageToRequireDev->modify($composerJson));
    }
}
