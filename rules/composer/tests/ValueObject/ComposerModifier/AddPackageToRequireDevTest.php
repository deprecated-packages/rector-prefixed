<?php

namespace Rector\Composer\Tests\ValueObject\ComposerModifier;

use RectorPrefix20210112\PHPUnit\Framework\TestCase;
use Rector\Composer\ValueObject\ComposerModifier\AddPackageToRequireDev;
use RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
final class AddPackageToRequireDevTest extends \RectorPrefix20210112\PHPUnit\Framework\TestCase
{
    public function testAddNonExistingPackage() : void
    {
        $composerJson = new \RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $changedComposerJson = new \RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $changedComposerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $changedComposerJson->setRequireDev(['vendor1/package3' => '^3.0']);
        $addPackageToRequireDev = new \Rector\Composer\ValueObject\ComposerModifier\AddPackageToRequireDev('vendor1/package3', '^3.0');
        $this->assertEquals($changedComposerJson, $addPackageToRequireDev->modify($composerJson));
    }
    public function testAddExistingPackage() : void
    {
        $composerJson = new \RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $changedComposerJson = new \RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $changedComposerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $addPackageToRequireDev = new \Rector\Composer\ValueObject\ComposerModifier\AddPackageToRequireDev('vendor1/package1', '^3.0');
        $this->assertEquals($changedComposerJson, $addPackageToRequireDev->modify($composerJson));
    }
    public function testAddExistingDevPackage() : void
    {
        $composerJson = new \RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0']);
        $composerJson->setRequireDev(['vendor1/package2' => '^2.0']);
        $changedComposerJson = new \RectorPrefix20210112\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $changedComposerJson->setRequire(['vendor1/package1' => '^1.0']);
        $changedComposerJson->setRequireDev(['vendor1/package2' => '^2.0']);
        $addPackageToRequireDev = new \Rector\Composer\ValueObject\ComposerModifier\AddPackageToRequireDev('vendor1/package2', '^3.0');
        $this->assertEquals($changedComposerJson, $addPackageToRequireDev->modify($composerJson));
    }
}
