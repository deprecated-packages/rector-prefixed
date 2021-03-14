<?php

declare (strict_types=1);
namespace RectorPrefix20210314\Symplify\ComposerJsonManipulator\Tests\ComposerJsonSchemaValidation;

use RectorPrefix20210314\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use RectorPrefix20210314\Symplify\ComposerJsonManipulator\Tests\HttpKernel\ComposerJsonManipulatorKernel;
use RectorPrefix20210314\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection;
use RectorPrefix20210314\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use RectorPrefix20210314\Symplify\SmartFileSystem\SmartFileSystem;
final class ComposerJsonSchemaValidationTest extends \RectorPrefix20210314\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var JsonFileManager
     */
    private $jsonFileManager;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    protected function setUp() : void
    {
        $this->bootKernel(\RectorPrefix20210314\Symplify\ComposerJsonManipulator\Tests\HttpKernel\ComposerJsonManipulatorKernel::class);
        $this->jsonFileManager = $this->getService(\RectorPrefix20210314\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager::class);
        $this->smartFileSystem = new \RectorPrefix20210314\Symplify\SmartFileSystem\SmartFileSystem();
    }
    public function testCheckEmptyKeysAreRemoved() : void
    {
        $sourceJsonPath = __DIR__ . '/Source/symfony-website_skeleton-composer.json';
        $targetJsonPath = \sys_get_temp_dir() . '/composer_json_manipulator_test_schema_validation.json';
        $sourceJson = $this->jsonFileManager->loadFromFilePath($sourceJsonPath);
        $this->smartFileSystem->dumpFile($targetJsonPath, $this->jsonFileManager->encodeJsonToFileContent($sourceJson));
        $sourceJson = $this->jsonFileManager->loadFromFilePath($sourceJsonPath);
        $targetJson = $this->jsonFileManager->loadFromFilePath($targetJsonPath);
        /*
         * Check empty keys are present in "source" but not in "target"
         */
        $this->assertArrayHasKey(\RectorPrefix20210314\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REQUIRE_DEV, $sourceJson);
        $this->assertArrayHasKey('auto-scripts', $sourceJson['scripts']);
        $this->assertArrayNotHasKey(\RectorPrefix20210314\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REQUIRE_DEV, $targetJson);
        $this->assertArrayNotHasKey('auto-scripts', $targetJson['scripts']);
    }
}
