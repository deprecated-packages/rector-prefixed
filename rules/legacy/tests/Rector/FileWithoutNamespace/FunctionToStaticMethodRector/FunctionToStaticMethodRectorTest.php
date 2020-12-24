<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Legacy\Tests\Rector\FileWithoutNamespace\FunctionToStaticMethodRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Legacy\Rector\FileWithoutNamespace\FunctionToStaticMethodRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class FunctionToStaticMethodRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $this->doTestFileInfo($smartFileInfo);
        $expectedClassFilePath = $this->getFixtureTempDirectory() . '/StaticFunctions.php';
        $this->assertFileExists($expectedClassFilePath);
        $this->assertFileEquals(__DIR__ . '/Source/ExpectedStaticFunctions.php', $expectedClassFilePath);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoperb75b35f52b74\Rector\Legacy\Rector\FileWithoutNamespace\FunctionToStaticMethodRector::class;
    }
}
