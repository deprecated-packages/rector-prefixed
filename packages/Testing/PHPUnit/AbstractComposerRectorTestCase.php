<?php

declare (strict_types=1);
namespace Rector\Testing\PHPUnit;

use RectorPrefix20210408\Nette\Utils\Json;
use Rector\Composer\Modifier\ComposerModifier;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\Tests\Composer\Contract\ConfigFileAwareInterface;
use RectorPrefix20210408\Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use RectorPrefix20210408\Symplify\EasyTesting\StaticFixtureSplitter;
use RectorPrefix20210408\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo;
abstract class AbstractComposerRectorTestCase extends \RectorPrefix20210408\Symplify\PackageBuilder\Testing\AbstractKernelTestCase implements \Rector\Tests\Composer\Contract\ConfigFileAwareInterface
{
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
        $this->composerModifier = $this->getService(\Rector\Composer\Modifier\ComposerModifier::class);
        $this->composerJsonFactory = $this->getService(\RectorPrefix20210408\Symplify\ComposerJsonManipulator\ComposerJsonFactory::class);
    }
    protected function doTestFileInfo(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $inputFileInfoAndExpected = \RectorPrefix20210408\Symplify\EasyTesting\StaticFixtureSplitter::splitFileInfoToLocalInputAndExpected($smartFileInfo);
        $composerJson = $this->composerJsonFactory->createFromFileInfo($inputFileInfoAndExpected->getInputFileInfo());
        $this->composerModifier->modify($composerJson);
        $changedComposerJson = \RectorPrefix20210408\Nette\Utils\Json::encode($composerJson->getJsonArray(), \RectorPrefix20210408\Nette\Utils\Json::PRETTY);
        $this->assertJsonStringEqualsJsonString($inputFileInfoAndExpected->getExpected(), $changedComposerJson);
    }
}
