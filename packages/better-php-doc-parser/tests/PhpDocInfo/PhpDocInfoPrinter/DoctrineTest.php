<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter;

use Iterator;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\Doctrine\CaseSensitive;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\Doctrine\IndexInTable;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\Doctrine\Short;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class DoctrineTest extends \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\AbstractPhpDocInfoPrinterTest
{
    /**
     * @dataProvider provideDataClass()
     */
    public function testClass(string $docFilePath, \_PhpScoper0a6b37af0871\PhpParser\Node $node) : void
    {
        $docComment = $this->smartFileSystem->readFile($docFilePath);
        $phpDocInfo = $this->createPhpDocInfoFromDocCommentAndNode($docComment, $node);
        $fileInfo = new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo($docFilePath);
        $relativeFilePathFromCwd = $fileInfo->getRelativeFilePathFromCwd();
        $this->assertSame($docComment, $this->phpDocInfoPrinter->printFormatPreserving($phpDocInfo), $relativeFilePathFromCwd);
    }
    public function provideDataClass() : \Iterator
    {
        (yield [__DIR__ . '/Source/Doctrine/index_in_table.txt', new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\Doctrine\IndexInTable::class)]);
        (yield [__DIR__ . '/Source/Doctrine/case_sensitive.txt', new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\Doctrine\CaseSensitive::class)]);
        (yield [__DIR__ . '/Source/Doctrine/short.txt', new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\Doctrine\Short::class)]);
    }
}
