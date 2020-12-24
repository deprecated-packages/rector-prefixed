<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Nop;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class PhpDocInfoPrinterTest extends \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\AbstractPhpDocInfoPrinterTest
{
    /**
     * @dataProvider provideData()
     * @dataProvider provideDataCallable()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $docFileInfo) : void
    {
        $this->doComparePrintedFileEquals($docFileInfo, $docFileInfo);
    }
    public function testRemoveSpace() : void
    {
        $this->doComparePrintedFileEquals(new \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/FixtureChanged/with_space.txt'), new \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/FixtureChangedExpected/with_space_expected.txt'));
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureBasic', '*.txt');
    }
    public function provideDataCallable() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureCallable', '*.txt');
    }
    /**
     * @dataProvider provideDataEmpty()
     */
    public function testEmpty(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $phpDocInfo = $this->createPhpDocInfoFromDocCommentAndNode($fileInfo->getContents(), new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Nop());
        $this->assertEmpty($this->phpDocInfoPrinter->printFormatPreserving($phpDocInfo));
    }
    public function provideDataEmpty() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureEmpty', '*.txt');
    }
    private function doComparePrintedFileEquals(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $inputFileInfo, \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $expectedFileInfo) : void
    {
        $phpDocInfo = $this->createPhpDocInfoFromDocCommentAndNode($inputFileInfo->getContents(), new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Nop());
        $printedDocComment = $this->phpDocInfoPrinter->printFormatPreserving($phpDocInfo);
        $this->assertSame($expectedFileInfo->getContents(), $printedDocComment, $inputFileInfo->getRelativeFilePathFromCwd());
    }
}
