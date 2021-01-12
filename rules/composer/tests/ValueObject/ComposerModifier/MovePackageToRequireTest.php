<?php

namespace Rector\Composer\Tests\ValueObject\ComposerModifier;

use RectorPrefix20210112\PHPUnit\Framework\TestCase;
use Rector\Composer\ValueObject\ComposerModifier\MovePackageToRequire;
use RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
final class MovePackageToRequireTest extends \RectorPrefix20210112\PHPUnit\Framework\TestCase
{
    public function testMoveNonExistingPackage() : void
    {
        $composerJson = new \RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $changedComposerJson = new \RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $changedComposerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $movePackageToRequire = new \Rector\Composer\ValueObject\ComposerModifier\MovePackageToRequire('vendor1/package3');
        $this->assertEquals($changedComposerJson, $movePackageToRequire->modify($composerJson));
    }
    public function testMoveExistingDevPackage() : void
    {
        $composerJson = new \RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequireDev(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $changedComposerJson = new \RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $changedComposerJson->setRequire(['vendor1/package1' => '^1.0']);
        $changedComposerJson->setRequireDev(['vendor1/package2' => '^2.0']);
        $movePackageToRequire = new \Rector\Composer\ValueObject\ComposerModifier\MovePackageToRequire('vendor1/package1');
        $this->assertEquals($changedComposerJson, $movePackageToRequire->modify($composerJson));
    }
    public function testMoveExistingPackage() : void
    {
        $composerJson = new \RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0']);
        $composerJson->setRequireDev(['vendor1/package2' => '^2.0']);
        $changedComposerJson = new \RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $changedComposerJson->setRequire(['vendor1/package1' => '^1.0']);
        $changedComposerJson->setRequireDev(['vendor1/package2' => '^2.0']);
        $movePackageToRequire = new \Rector\Composer\ValueObject\ComposerModifier\MovePackageToRequire('vendor1/package1');
        $this->assertEquals($changedComposerJson, $movePackageToRequire->modify($composerJson));
    }
}
