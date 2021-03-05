<?php

declare (strict_types=1);
namespace Rector\Composer\Tests\Rector;

use RectorPrefix20210305\Nette\Utils\Json;
use Rector\Composer\Modifier\ComposerModifier;
use Rector\Composer\Tests\Contract\ConfigFileAwareInterface;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\Testing\Guard\FixtureGuard;
use RectorPrefix20210305\Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use RectorPrefix20210305\Symplify\EasyTesting\StaticFixtureSplitter;
use RectorPrefix20210305\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use RectorPrefix20210305\Symplify\SmartFileSystem\SmartFileInfo;
abstract class AbstractComposerRectorTestCase extends \RectorPrefix20210305\Symplify\PackageBuilder\Testing\AbstractKernelTestCase implements \Rector\Composer\Tests\Contract\ConfigFileAwareInterface
{
    /**
     * @var FixtureGuard
     */
    private $fixtureGuard;
    /**
     * @var ComposerJsonFactory
     */
    private $composerJsonFactory;
    /**
     * @var ComposerModifier
     */
    private $composerModifier;
    protected function setUp() : void
    {
        $this->bootKernelWithConfigs(\Rector\Core\HttpKernel\RectorKernel::class, [$this->provideConfigFile()]);
        $this->fixtureGuard = $this->getService(\Rector\Testing\Guard\FixtureGuard::class);
        $this->composerModifier = $this->getService(\Rector\Composer\Modifier\ComposerModifier::class);
        $this->composerJsonFactory = $this->getService(\RectorPrefix20210305\Symplify\ComposerJsonManipulator\ComposerJsonFactory::class);
    }
    protected function doTestFileInfo(\RectorPrefix20210305\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $this->fixtureGuard->ensureFileInfoHasDifferentBeforeAndAfterContent($smartFileInfo);
        $inputFileInfoAndExpected = \RectorPrefix20210305\Symplify\EasyTesting\StaticFixtureSplitter::splitFileInfoToLocalInputAndExpected($smartFileInfo);
        $composerJson = $this->composerJsonFactory->createFromFileInfo($inputFileInfoAndExpected->getInputFileInfo());
        $this->composerModifier->modify($composerJson);
        $changedComposerJson = \RectorPrefix20210305\Nette\Utils\Json::encode($composerJson->getJsonArray(), \RectorPrefix20210305\Nette\Utils\Json::PRETTY);
        $this->assertJsonStringEqualsJsonString($inputFileInfoAndExpected->getExpected(), $changedComposerJson);
    }
}
