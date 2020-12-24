<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Legacy\Tests\Rector\FileWithoutNamespace\FunctionToStaticMethodRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Legacy\Rector\FileWithoutNamespace\FunctionToStaticMethodRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class FunctionToStaticMethodRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
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
        return \_PhpScoper0a6b37af0871\Rector\Legacy\Rector\FileWithoutNamespace\FunctionToStaticMethodRector::class;
    }
}
