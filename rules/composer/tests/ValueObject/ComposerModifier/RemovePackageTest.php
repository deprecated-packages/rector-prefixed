<?php

declare (strict_types=1);
namespace Rector\Composer\Tests\ValueObject\ComposerModifier;

use RectorPrefix20210115\PHPUnit\Framework\TestCase;
use Rector\Composer\ValueObject\ComposerModifier\RemovePackage;
use RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
final class RemovePackageTest extends \RectorPrefix20210115\PHPUnit\Framework\TestCase
{
    public function testRemoveNonExistingPackage() : void
    {
        $composerJson = new \RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $expectedComposerJson = new \RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $expectedComposerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $removePackage = new \Rector\Composer\ValueObject\ComposerModifier\RemovePackage('vendor1/package3');
        $removePackage->modify($composerJson);
        $this->assertSame($expectedComposerJson->getJsonArray(), $composerJson->getJsonArray());
    }
    public function testRemoveExistingPackage() : void
    {
        $composerJson = new \RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $expectedComposerJson = new \RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $expectedComposerJson->setRequire(['vendor1/package2' => '^2.0']);
        $removePackage = new \Rector\Composer\ValueObject\ComposerModifier\RemovePackage('vendor1/package1');
        $removePackage->modify($composerJson);
        $this->assertSame($expectedComposerJson->getJsonArray(), $composerJson->getJsonArray());
    }
    public function testRemoveExistingDevPackage() : void
    {
        $composerJson = new \RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0']);
        $composerJson->setRequireDev(['vendor1/package2' => '^2.0']);
        $expectedComposerJson = new \RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $expectedComposerJson->setRequire(['vendor1/package1' => '^1.0']);
        $removePackage = new \Rector\Composer\ValueObject\ComposerModifier\RemovePackage('vendor1/package2');
        $removePackage->modify($composerJson);
        $this->assertSame($expectedComposerJson->getJsonArray(), $composerJson->getJsonArray());
    }
}
