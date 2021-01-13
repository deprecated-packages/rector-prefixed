<?php

namespace Rector\Composer\Tests\ValueObject\ComposerModifier;

use RectorPrefix20210113\PHPUnit\Framework\TestCase;
use Rector\Composer\ValueObject\ComposerModifier\RemovePackage;
use RectorPrefix20210113\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
final class RemovePackageTest extends \RectorPrefix20210113\PHPUnit\Framework\TestCase
{
    public function testRemoveNonExistingPackage() : void
    {
        $composerJson = new \RectorPrefix20210113\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $changedComposerJson = new \RectorPrefix20210113\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $changedComposerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $removePackage = new \Rector\Composer\ValueObject\ComposerModifier\RemovePackage('vendor1/package3');
        $this->assertEquals($changedComposerJson, $removePackage->modify($composerJson));
    }
    public function testRemoveExistingPackage() : void
    {
        $composerJson = new \RectorPrefix20210113\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $changedComposerJson = new \RectorPrefix20210113\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $changedComposerJson->setRequire(['vendor1/package2' => '^2.0']);
        $removePackage = new \Rector\Composer\ValueObject\ComposerModifier\RemovePackage('vendor1/package1');
        $this->assertEquals($changedComposerJson, $removePackage->modify($composerJson));
    }
    public function testRemoveExistingDevPackage() : void
    {
        $composerJson = new \RectorPrefix20210113\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0']);
        $composerJson->setRequireDev(['vendor1/package2' => '^2.0']);
        $changedComposerJson = new \RectorPrefix20210113\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $changedComposerJson->setRequire(['vendor1/package1' => '^1.0']);
        $removePackage = new \Rector\Composer\ValueObject\ComposerModifier\RemovePackage('vendor1/package2');
        $this->assertEquals($changedComposerJson, $removePackage->modify($composerJson));
    }
}
