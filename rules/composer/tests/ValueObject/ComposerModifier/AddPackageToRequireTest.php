<?php

declare (strict_types=1);
namespace Rector\Composer\Tests\ValueObject\ComposerModifier;

use RectorPrefix20210115\PHPUnit\Framework\TestCase;
use Rector\Composer\ValueObject\ComposerModifier\AddPackageToRequire;
use RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
final class AddPackageToRequireTest extends \RectorPrefix20210115\PHPUnit\Framework\TestCase
{
    public function testAddNonExistingPackage() : void
    {
        $composerJson = new \RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $expectedComposerJson = new \RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $expectedComposerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0', 'vendor1/package3' => '^3.0']);
        $addPackageToRequire = new \Rector\Composer\ValueObject\ComposerModifier\AddPackageToRequire('vendor1/package3', '^3.0');
        $addPackageToRequire->modify($composerJson);
        $this->assertSame($expectedComposerJson->getJsonArray(), $composerJson->getJsonArray());
    }
    public function testAddExistingPackage() : void
    {
        $composerJson = new \RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $expectedComposerJson = new \RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $expectedComposerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $addPackageToRequire = new \Rector\Composer\ValueObject\ComposerModifier\AddPackageToRequire('vendor1/package1', '^3.0');
        $addPackageToRequire->modify($composerJson);
        $this->assertSame($expectedComposerJson->getJsonArray(), $composerJson->getJsonArray());
    }
    public function testAddExistingDevPackage() : void
    {
        $composerJson = new \RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0']);
        $composerJson->setRequireDev(['vendor1/package2' => '^2.0']);
        $expectedComposerJson = new \RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $expectedComposerJson->setRequire(['vendor1/package1' => '^1.0']);
        $expectedComposerJson->setRequireDev(['vendor1/package2' => '^2.0']);
        $addPackageToRequire = new \Rector\Composer\ValueObject\ComposerModifier\AddPackageToRequire('vendor1/package2', '^3.0');
        $addPackageToRequire->modify($composerJson);
        $this->assertSame($expectedComposerJson->getJsonArray(), $composerJson->getJsonArray());
    }
}
