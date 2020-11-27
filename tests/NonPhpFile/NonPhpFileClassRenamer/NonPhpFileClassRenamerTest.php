<?php

declare (strict_types=1);
namespace Rector\Core\Tests\NonPhpFile\NonPhpFileClassRenamer;

use Iterator;
use Rector\Core\Configuration\Option;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\Core\NonPhpFile\NonPhpFileClassRenamer;
use Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass;
use Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass;
use Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use Symplify\EasyTesting\StaticFixtureSplitter;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class NonPhpFileClassRenamerTest extends \Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var array<string, string>
     */
    private const CLASS_RENAMES = [
        'Session' => '_PhpScoperbd5d0c5f7638\\Illuminate\\Support\\Facades\\Session',
        \Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass::class => \Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass::class,
        // Laravel
        'Form' => '_PhpScoperbd5d0c5f7638\\Collective\\Html\\FormFacade',
        'Html' => '_PhpScoperbd5d0c5f7638\\Collective\\Html\\HtmlFacade',
    ];
    /**
     * @var NonPhpFileClassRenamer
     */
    private $nonPhpFileClassRenamer;
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    protected function setUp() : void
    {
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->nonPhpFileClassRenamer = self::$container->get(\Rector\Core\NonPhpFile\NonPhpFileClassRenamer::class);
        $this->parameterProvider = self::$container->get(\Symplify\PackageBuilder\Parameter\ParameterProvider::class);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo) : void
    {
        $this->parameterProvider->changeParameter(\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \false);
        $inputAndExpected = \Symplify\EasyTesting\StaticFixtureSplitter::splitFileInfoToInputAndExpected($fixtureFileInfo);
        $changedContent = $this->nonPhpFileClassRenamer->renameClasses($inputAndExpected->getInput(), self::CLASS_RENAMES);
        $this->assertSame($inputAndExpected->getExpected(), $changedContent);
    }
    public function provideData() : \Iterator
    {
        return \Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectory(__DIR__ . '/Fixture', '*');
    }
}
