<?php

declare (strict_types=1);
namespace Rector\RectorGenerator\Tests\ValueObjectFactory;

use Rector\Core\HttpKernel\RectorKernel;
use Rector\RectorGenerator\Exception\ConfigurationException;
use Rector\RectorGenerator\Generator\RectorRecipeGenerator;
use Rector\RectorGenerator\Testing\ManualInteractiveInputProvider;
use Rector\RectorGenerator\ValueObjectFactory\RectorRecipeInteractiveFactory;
use RectorPrefix20210105\Symplify\EasyTesting\PHPUnit\Behavior\DirectoryAssertableTrait;
use RectorPrefix20210105\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use RectorPrefix20210105\Symplify\SmartFileSystem\SmartFileSystem;
final class RectorRecipeInteractiveProviderTest extends \RectorPrefix20210105\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    use DirectoryAssertableTrait;
    /**
     * @var string
     */
    private const DESTINATION_DIRECTORY = __DIR__ . '/__temp';
    /**
     * @var RectorRecipeInteractiveFactory
     */
    private $rectorRecipeInteractiveFactory;
    /**
     * @var RectorRecipeGenerator
     */
    private $rectorRecipeGenerator;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var ManualInteractiveInputProvider
     */
    private $manualInteractiveInputProvider;
    protected function setUp() : void
    {
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->rectorRecipeInteractiveFactory = $this->getService(\Rector\RectorGenerator\ValueObjectFactory\RectorRecipeInteractiveFactory::class);
        $this->rectorRecipeGenerator = $this->getService(\Rector\RectorGenerator\Generator\RectorRecipeGenerator::class);
        $this->manualInteractiveInputProvider = $this->getService(\Rector\RectorGenerator\Testing\ManualInteractiveInputProvider::class);
        $this->smartFileSystem = $this->getService(\RectorPrefix20210105\Symplify\SmartFileSystem\SmartFileSystem::class);
    }
    public function test() : void
    {
        $this->manualInteractiveInputProvider->setInput(['Naming', 'T', 'Arg', 'Description']);
        $this->expectException(\Rector\RectorGenerator\Exception\ConfigurationException::class);
        $this->expectExceptionMessage('Rector name "T" must end with "Rector"');
        $this->rectorRecipeInteractiveFactory->create();
    }
    public function testGeneratesRectorRule() : void
    {
        $this->manualInteractiveInputProvider->setInput(['TestPackageName', 'TestRector', 'Arg', 'Description', null, null, 'no']);
        $rectorRecipe = $this->rectorRecipeInteractiveFactory->create();
        // generate
        $this->rectorRecipeGenerator->generate($rectorRecipe, self::DESTINATION_DIRECTORY);
        // compare it
        $this->assertDirectoryEquals(__DIR__ . '/Fixture/expected_interactive', self::DESTINATION_DIRECTORY);
        // clear it
        $this->smartFileSystem->remove(self::DESTINATION_DIRECTORY);
    }
}
