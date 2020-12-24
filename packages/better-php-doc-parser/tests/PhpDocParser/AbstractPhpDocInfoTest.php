<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocParser;

use Iterator;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocParser\Helper\TagValueToPhpParserNodeMap;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a6b37af0871\Rector\FileSystemRector\Parser\FileInfoParser;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
abstract class AbstractPhpDocInfoTest extends \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var FileInfoParser
     */
    private $fileInfoParser;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var PhpDocInfoPrinter
     */
    private $phpDocInfoPrinter;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel::class);
        $this->fileInfoParser = $this->getService(\_PhpScoper0a6b37af0871\Rector\FileSystemRector\Parser\FileInfoParser::class);
        $this->betterNodeFinder = $this->getService(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder::class);
        $this->phpDocInfoPrinter = $this->getService(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter::class);
    }
    /**
     * @param class-string $tagValueNodeType
     */
    protected function doTestPrintedPhpDocInfo(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, string $tagValueNodeType) : void
    {
        if (!isset(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocParser\Helper\TagValueToPhpParserNodeMap::MAP[$tagValueNodeType])) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException(\sprintf('[tests] Add "%s" to %s::%s constant', $tagValueNodeType, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocParser\Helper\TagValueToPhpParserNodeMap::class, 'MAP'));
        }
        $nodeType = \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocParser\Helper\TagValueToPhpParserNodeMap::MAP[$tagValueNodeType];
        $nodeWithPhpDocInfo = $this->parseFileAndGetFirstNodeOfType($fileInfo, $nodeType);
        $docComment = $nodeWithPhpDocInfo->getDocComment();
        if ($docComment === null) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException(\sprintf('Doc comments for "%s" file cannot not be empty', $fileInfo));
        }
        $originalDocCommentText = $docComment->getText();
        $printedPhpDocInfo = $this->printNodePhpDocInfoToString($nodeWithPhpDocInfo);
        $errorMessage = $this->createErrorMessage($fileInfo);
        $this->assertSame($originalDocCommentText, $printedPhpDocInfo, $errorMessage);
        $this->doTestContainsTagValueNodeType($nodeWithPhpDocInfo, $tagValueNodeType, $fileInfo);
    }
    protected function yieldFilesFromDirectory(string $directory, string $suffix = '*.php') : \Iterator
    {
        return \_PhpScoper0a6b37af0871\Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectory($directory, $suffix);
    }
    protected function findFilesFromDirectory(string $directory, string $suffix = '*.php') : \Iterator
    {
        return \_PhpScoper0a6b37af0871\Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectory($directory, $suffix);
    }
    /**
     * @param class-string $nodeType
     */
    private function parseFileAndGetFirstNodeOfType(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, string $nodeType) : \_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $nodes = $this->fileInfoParser->parseFileInfoToNodesAndDecorate($fileInfo);
        return $this->betterNodeFinder->findFirstInstanceOf($nodes, $nodeType);
    }
    private function printNodePhpDocInfoToString(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : string
    {
        $phpDocInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $this->phpDocInfoPrinter->printFormatPreserving($phpDocInfo);
    }
    private function createErrorMessage(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : string
    {
        return 'Caused by: ' . $fileInfo->getRelativeFilePathFromCwd() . \PHP_EOL;
    }
    private function doTestContainsTagValueNodeType(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $tagValueNodeType, \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $this->assertTrue($phpDocInfo->hasByType($tagValueNodeType), $fileInfo->getRelativeFilePathFromCwd());
    }
}
