<?php

declare (strict_types=1);
namespace Rector\Composer\Tests\ValueObject\ComposerModifier;

use RectorPrefix20210115\PHPUnit\Framework\TestCase;
use Rector\Composer\ValueObject\ComposerModifier\ReplacePackage;
use RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
final class ReplacePackageTest extends \RectorPrefix20210115\PHPUnit\Framework\TestCase
{
    public function testReplaceNonExistingPackage() : void
    {
        $composerJson = new \RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $expectedComposerJson = new \RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $expectedComposerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $replacePackage = new \Rector\Composer\ValueObject\ComposerModifier\ReplacePackage('vendor1/package3', 'vendor1/package4', '^3.0');
        $replacePackage->modify($composerJson);
        $this->assertSame($expectedComposerJson->getJsonArray(), $composerJson->getJsonArray());
    }
    public function testReplaceExistingPackage() : void
    {
        $composerJson = new \RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $expectedComposerJson = new \RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $expectedComposerJson->setRequire(['vendor1/package3' => '^3.0', 'vendor1/package2' => '^2.0']);
        $replacePackage = new \Rector\Composer\ValueObject\ComposerModifier\ReplacePackage('vendor1/package1', 'vendor1/package3', '^3.0');
        $replacePackage->modify($composerJson);
        $this->assertSame($expectedComposerJson->getJsonArray(), $composerJson->getJsonArray());
    }
    public function testReplaceExistingDevPackage() : void
    {
        $composerJson = new \RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0']);
        $composerJson->setRequireDev(['vendor1/package2' => '^2.0']);
        $expectedComposerJson = new \RectorPrefix20210115\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $expectedComposerJson->setRequire(['vendor1/package1' => '^1.0']);
        $expectedComposerJson->setRequireDev(['vendor1/package3' => '^3.0']);
        $replacePackage = new \Rector\Composer\ValueObject\ComposerModifier\ReplacePackage('vendor1/package2', 'vendor1/package3', '^3.0');
        $replacePackage->modify($composerJson);
        $this->assertSame($expectedComposerJson->getJsonArray(), $composerJson->getJsonArray());
    }
}
