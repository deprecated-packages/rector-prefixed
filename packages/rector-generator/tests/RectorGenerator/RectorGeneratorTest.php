<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RectorGenerator\Tests\RectorGenerator;

use _PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel;
use _PhpScopere8e811afab72\Rector\RectorGenerator\Finder\TemplateFinder;
use _PhpScopere8e811afab72\Rector\RectorGenerator\Generator\FileGenerator;
use _PhpScopere8e811afab72\Rector\RectorGenerator\TemplateVariablesFactory;
use _PhpScopere8e811afab72\Rector\RectorGenerator\Tests\RectorGenerator\Source\StaticRectorRecipeFactory;
use _PhpScopere8e811afab72\Rector\RectorGenerator\ValueObject\RectorRecipe;
use _PhpScopere8e811afab72\Symplify\EasyTesting\PHPUnit\Behavior\DirectoryAssertableTrait;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
final class RectorGeneratorTest extends \_PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    use DirectoryAssertableTrait;
    /**
     * @var string
     */
    private const DESTINATION_DIRECTORY = __DIR__ . '/__temp';
    /**
     * @var TemplateVariablesFactory
     */
    private $templateVariablesFactory;
    /**
     * @var TemplateFinder
     */
    private $templateFinder;
    /**
     * @var FileGenerator
     */
    private $fileGenerator;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel::class);
        $this->templateVariablesFactory = $this->getService(\_PhpScopere8e811afab72\Rector\RectorGenerator\TemplateVariablesFactory::class);
        $this->templateFinder = $this->getService(\_PhpScopere8e811afab72\Rector\RectorGenerator\Finder\TemplateFinder::class);
        $this->fileGenerator = $this->getService(\_PhpScopere8e811afab72\Rector\RectorGenerator\Generator\FileGenerator::class);
        $this->smartFileSystem = $this->getService(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem::class);
    }
    protected function tearDown() : void
    {
        // cleanup temporary data
        $this->smartFileSystem->remove(self::DESTINATION_DIRECTORY);
    }
    public function test() : void
    {
        $this->doGenerateFiles(\true);
        $this->assertDirectoryEquals(__DIR__ . '/Fixture/expected', self::DESTINATION_DIRECTORY);
    }
    public function test3rdParty() : void
    {
        $this->doGenerateFiles(\false);
        $this->assertDirectoryEquals(__DIR__ . '/Fixture/expected_3rd_party', self::DESTINATION_DIRECTORY);
    }
    private function doGenerateFiles(bool $isRectorRepository) : void
    {
        $rectorRecipe = $this->createConfiguration($isRectorRepository);
        $templateFileInfos = $this->templateFinder->find($rectorRecipe);
        $templateVariables = $this->templateVariablesFactory->createFromRectorRecipe($rectorRecipe);
        $this->fileGenerator->generateFiles($templateFileInfos, $templateVariables, $rectorRecipe, self::DESTINATION_DIRECTORY);
    }
    private function createConfiguration(bool $isRectorRepository) : \_PhpScopere8e811afab72\Rector\RectorGenerator\ValueObject\RectorRecipe
    {
        return \_PhpScopere8e811afab72\Rector\RectorGenerator\Tests\RectorGenerator\Source\StaticRectorRecipeFactory::createRectorRecipe($isRectorRepository);
    }
}
