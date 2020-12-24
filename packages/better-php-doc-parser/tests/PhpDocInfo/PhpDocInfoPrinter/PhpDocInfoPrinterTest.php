<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter;

use Iterator;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Nop;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class PhpDocInfoPrinterTest extends \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\AbstractPhpDocInfoPrinterTest
{
    /**
     * @dataProvider provideData()
     * @dataProvider provideDataCallable()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $docFileInfo) : void
    {
        $this->doComparePrintedFileEquals($docFileInfo, $docFileInfo);
    }
    public function testRemoveSpace() : void
    {
        $this->doComparePrintedFileEquals(new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/FixtureChanged/with_space.txt'), new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/FixtureChangedExpected/with_space_expected.txt'));
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
    public function testEmpty(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $phpDocInfo = $this->createPhpDocInfoFromDocCommentAndNode($fileInfo->getContents(), new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Nop());
        $this->assertEmpty($this->phpDocInfoPrinter->printFormatPreserving($phpDocInfo));
    }
    public function provideDataEmpty() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureEmpty', '*.txt');
    }
    private function doComparePrintedFileEquals(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $inputFileInfo, \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $expectedFileInfo) : void
    {
        $phpDocInfo = $this->createPhpDocInfoFromDocCommentAndNode($inputFileInfo->getContents(), new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Nop());
        $printedDocComment = $this->phpDocInfoPrinter->printFormatPreserving($phpDocInfo);
        $this->assertSame($expectedFileInfo->getContents(), $printedDocComment, $inputFileInfo->getRelativeFilePathFromCwd());
    }
}
