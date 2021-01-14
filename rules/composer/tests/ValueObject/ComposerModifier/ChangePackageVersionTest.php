<?php

declare (strict_types=1);
namespace Rector\Composer\Tests\ValueObject\ComposerModifier;

use RectorPrefix20210114\PHPUnit\Framework\TestCase;
use Rector\Composer\ValueObject\ComposerModifier\ChangePackageVersion;
use RectorPrefix20210114\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
final class ChangePackageVersionTest extends \RectorPrefix20210114\PHPUnit\Framework\TestCase
{
    public function testChangeVersionNonExistingPackage() : void
    {
        $composerJson = new \RectorPrefix20210114\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $expectedComposerJson = new \RectorPrefix20210114\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $expectedComposerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $changePackageVersion = new \Rector\Composer\ValueObject\ComposerModifier\ChangePackageVersion('vendor1/package3', '^3.0');
        $changePackageVersion->modify($composerJson);
        $this->assertSame($expectedComposerJson->getJsonArray(), $composerJson->getJsonArray());
    }
    public function testChangeVersionExistingPackage() : void
    {
        $composerJson = new \RectorPrefix20210114\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0', 'vendor1/package2' => '^2.0']);
        $expectedComposerJson = new \RectorPrefix20210114\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $expectedComposerJson->setRequire(['vendor1/package1' => '^3.0', 'vendor1/package2' => '^2.0']);
        $changePackageVersion = new \Rector\Composer\ValueObject\ComposerModifier\ChangePackageVersion('vendor1/package1', '^3.0');
        $changePackageVersion->modify($composerJson);
        $this->assertSame($expectedComposerJson->getJsonArray(), $composerJson->getJsonArray());
    }
    public function testChangeVersionExistingDevPackage() : void
    {
        $composerJson = new \RectorPrefix20210114\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $composerJson->setRequire(['vendor1/package1' => '^1.0']);
        $composerJson->setRequireDev(['vendor1/package2' => '^2.0']);
        $expectedComposerJson = new \RectorPrefix20210114\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        $expectedComposerJson->setRequire(['vendor1/package1' => '^1.0']);
        $expectedComposerJson->setRequireDev(['vendor1/package2' => '^3.0']);
        $changePackageVersion = new \Rector\Composer\ValueObject\ComposerModifier\ChangePackageVersion('vendor1/package2', '^3.0');
        $changePackageVersion->modify($composerJson);
        $this->assertSame($expectedComposerJson->getJsonArray(), $composerJson->getJsonArray());
    }
}
