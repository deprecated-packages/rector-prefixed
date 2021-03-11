<?php

declare (strict_types=1);
namespace RectorPrefix20210311\Symplify\ComposerJsonManipulator\Tests\ComposerJsonFactory;

use RectorPrefix20210311\Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use RectorPrefix20210311\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use RectorPrefix20210311\Symplify\ComposerJsonManipulator\Tests\HttpKernel\ComposerJsonManipulatorKernel;
use RectorPrefix20210311\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use RectorPrefix20210311\Symplify\SmartFileSystem\SmartFileInfo;
final class ComposerJsonFactoryTest extends \RectorPrefix20210311\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var string
     */
    private const FULL_COMPOSER_JSON_FILE_PATH = __DIR__ . '/Source/full_composer.json';
    /**
     * @var ComposerJsonFactory
     */
    private $composerJsonFactory;
    /**
     * @var JsonFileManager
     */
    private $jsonFileManager;
    protected function setUp() : void
    {
        $this->bootKernel(\RectorPrefix20210311\Symplify\ComposerJsonManipulator\Tests\HttpKernel\ComposerJsonManipulatorKernel::class);
        $this->composerJsonFactory = $this->getService(\RectorPrefix20210311\Symplify\ComposerJsonManipulator\ComposerJsonFactory::class);
        $this->jsonFileManager = $this->getService(\RectorPrefix20210311\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager::class);
    }
    public function test() : void
    {
        $composerJson = $this->composerJsonFactory->createFromFilePath(__DIR__ . '/Source/some_composer.json');
        $fileInfo = $composerJson->getFileInfo();
        $this->assertInstanceOf(\RectorPrefix20210311\Symplify\SmartFileSystem\SmartFileInfo::class, $fileInfo);
        /** @var SmartFileInfo $fileInfo */
        $this->assertCount(2, $composerJson->getAllClassmaps());
        $this->assertSame(['directory', 'src'], $composerJson->getPsr4AndClassmapDirectories());
        $this->assertSame(['symplify/between' => '^8.3.45'], $composerJson->getReplace());
        $this->assertSame('project', $composerJson->getType());
    }
    public function testReprint() : void
    {
        $composerJson = $this->composerJsonFactory->createFromFilePath(self::FULL_COMPOSER_JSON_FILE_PATH);
        $actualJson = $this->jsonFileManager->encodeJsonToFileContent($composerJson->getJsonArray());
        $this->assertJsonStringEqualsJsonFile(self::FULL_COMPOSER_JSON_FILE_PATH, $actualJson);
    }
}
