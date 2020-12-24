<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\RectorGenerator\Tests\RectorGenerator;

use _PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoper0a6b37af0871\Rector\RectorGenerator\Finder\TemplateFinder;
use _PhpScoper0a6b37af0871\Rector\RectorGenerator\Generator\FileGenerator;
use _PhpScoper0a6b37af0871\Rector\RectorGenerator\TemplateVariablesFactory;
use _PhpScoper0a6b37af0871\Rector\RectorGenerator\Tests\RectorGenerator\Source\StaticRectorRecipeFactory;
use _PhpScoper0a6b37af0871\Rector\RectorGenerator\ValueObject\RectorRecipe;
use _PhpScoper0a6b37af0871\Symplify\EasyTesting\PHPUnit\Behavior\DirectoryAssertableTrait;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem;
final class RectorGeneratorTest extends \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
        $this->bootKernel(\_PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel::class);
        $this->templateVariablesFactory = $this->getService(\_PhpScoper0a6b37af0871\Rector\RectorGenerator\TemplateVariablesFactory::class);
        $this->templateFinder = $this->getService(\_PhpScoper0a6b37af0871\Rector\RectorGenerator\Finder\TemplateFinder::class);
        $this->fileGenerator = $this->getService(\_PhpScoper0a6b37af0871\Rector\RectorGenerator\Generator\FileGenerator::class);
        $this->smartFileSystem = $this->getService(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem::class);
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
    private function createConfiguration(bool $isRectorRepository) : \_PhpScoper0a6b37af0871\Rector\RectorGenerator\ValueObject\RectorRecipe
    {
        return \_PhpScoper0a6b37af0871\Rector\RectorGenerator\Tests\RectorGenerator\Source\StaticRectorRecipeFactory::createRectorRecipe($isRectorRepository);
    }
}
