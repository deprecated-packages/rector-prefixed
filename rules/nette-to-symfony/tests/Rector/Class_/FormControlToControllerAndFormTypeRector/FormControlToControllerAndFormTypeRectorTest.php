<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Tests\Rector\Class_\FormControlToControllerAndFormTypeRector;

use Iterator;
use Rector\NetteToSymfony\Rector\Class_\FormControlToControllerAndFormTypeRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210220\Symplify\SmartFileSystem\SmartFileInfo;
final class FormControlToControllerAndFormTypeRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210220\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, string $expectedExtraFileName, string $expectedExtraContentFilePath) : void
    {
        $this->doTestFileInfo($fileInfo);
        $this->doTestExtraFile($expectedExtraFileName, $expectedExtraContentFilePath);
    }
    public function provideData() : \Iterator
    {
        (yield [new \RectorPrefix20210220\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/fixture.php.inc'), 'src/Controller/SomeFormController.php', __DIR__ . '/Source/extra_file.php']);
    }
    protected function getRectorClass() : string
    {
        return \Rector\NetteToSymfony\Rector\Class_\FormControlToControllerAndFormTypeRector::class;
    }
}
