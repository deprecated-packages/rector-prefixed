<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteToSymfony\Tests\Rector\Class_\FormControlToControllerAndFormTypeRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\NetteToSymfony\Rector\Class_\FormControlToControllerAndFormTypeRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class FormControlToControllerAndFormTypeRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, string $expectedExtraFileName, string $expectedExtraContentFilePath) : void
    {
        $this->doTestFileInfo($fileInfo);
        $this->doTestExtraFile($expectedExtraFileName, $expectedExtraContentFilePath);
    }
    public function provideData() : \Iterator
    {
        (yield [new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/fixture.php.inc'), 'SomeFormController.php', __DIR__ . '/Source/extra_file.php']);
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\NetteToSymfony\Rector\Class_\FormControlToControllerAndFormTypeRector::class;
    }
}
