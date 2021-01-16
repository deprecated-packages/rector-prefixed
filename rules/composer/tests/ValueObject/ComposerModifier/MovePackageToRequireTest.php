<?php

declare (strict_types=1);
namespace Rector\Composer\Tests\ValueObject\ComposerModifier;

use RectorPrefix20210116\PHPUnit\Framework\TestCase;
use Rector\Composer\ValueObject\ComposerModifier\MovePackageToRequire;
use RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
final class MovePackageToRequireTest extends \RectorPrefix20210116\PHPUnit\Framework\TestCase
{
    public function testMoveNonExistingPackage() : void
    {
        $composerJson = new \RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $expectedComposerJson = new \RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $expectedComposerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $movePackageToRequire = new \Rector\Composer\ValueObject\ComposerModifier\MovePackageToRequire('vendor1/package3');
        $movePackageToRequire->modify($composerJson);
        $this->assertSame($expectedComposerJson->getJsonArray(), $composerJson->getJsonArray());
    }
    public function testMoveExistingDevPackage() : void
    {
        $composerJson = new \RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequireDev(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $expectedComposerJson = new \RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $expectedComposerJson->setRequire(['vendor1/package1' => '^1.0']);
        $expectedComposerJson->setRequireDev(['vendor1/package2' => '^2.0']);
        $movePackageToRequire = new \Rector\Composer\ValueObject\ComposerModifier\MovePackageToRequire('vendor1/package1');
        $movePackageToRequire->modify($composerJson);
        $this->assertSame($expectedComposerJson->getJsonArray(), $composerJson->getJsonArray());
    }
    public function testMoveExistingPackage() : void
    {
        $composerJson = new \RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0']);
        $composerJson->setRequireDev(['vendor1/package2' => '^2.0']);
        $expectedComposerJson = new \RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $expectedComposerJson->setRequire(['vendor1/package1' => '^1.0']);
        $expectedComposerJson->setRequireDev(['vendor1/package2' => '^2.0']);
        $movePackageToRequire = new \Rector\Composer\ValueObject\ComposerModifier\MovePackageToRequire('vendor1/package1');
        $movePackageToRequire->modify($composerJson);
        $this->assertSame($expectedComposerJson->getJsonArray(), $composerJson->getJsonArray());
    }
}
