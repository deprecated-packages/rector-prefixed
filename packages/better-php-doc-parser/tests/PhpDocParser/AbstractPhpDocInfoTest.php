<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocParser;

use Iterator;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocParser\Helper\TagValueToPhpParserNodeMap;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\FileSystemRector\Parser\FileInfoParser;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
abstract class AbstractPhpDocInfoTest extends \_PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
        $this->bootKernel(\_PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel::class);
        $this->fileInfoParser = $this->getService(\_PhpScopere8e811afab72\Rector\FileSystemRector\Parser\FileInfoParser::class);
        $this->betterNodeFinder = $this->getService(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder::class);
        $this->phpDocInfoPrinter = $this->getService(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter::class);
    }
    /**
     * @param class-string $tagValueNodeType
     */
    protected function doTestPrintedPhpDocInfo(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, string $tagValueNodeType) : void
    {
        if (!isset(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocParser\Helper\TagValueToPhpParserNodeMap::MAP[$tagValueNodeType])) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException(\sprintf('[tests] Add "%s" to %s::%s constant', $tagValueNodeType, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocParser\Helper\TagValueToPhpParserNodeMap::class, 'MAP'));
        }
        $nodeType = \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocParser\Helper\TagValueToPhpParserNodeMap::MAP[$tagValueNodeType];
        $nodeWithPhpDocInfo = $this->parseFileAndGetFirstNodeOfType($fileInfo, $nodeType);
        $docComment = $nodeWithPhpDocInfo->getDocComment();
        if ($docComment === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException(\sprintf('Doc comments for "%s" file cannot not be empty', $fileInfo));
        }
        $originalDocCommentText = $docComment->getText();
        $printedPhpDocInfo = $this->printNodePhpDocInfoToString($nodeWithPhpDocInfo);
        $errorMessage = $this->createErrorMessage($fileInfo);
        $this->assertSame($originalDocCommentText, $printedPhpDocInfo, $errorMessage);
        $this->doTestContainsTagValueNodeType($nodeWithPhpDocInfo, $tagValueNodeType, $fileInfo);
    }
    protected function yieldFilesFromDirectory(string $directory, string $suffix = '*.php') : \Iterator
    {
        return \_PhpScopere8e811afab72\Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectory($directory, $suffix);
    }
    protected function findFilesFromDirectory(string $directory, string $suffix = '*.php') : \Iterator
    {
        return \_PhpScopere8e811afab72\Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectory($directory, $suffix);
    }
    /**
     * @param class-string $nodeType
     */
    private function parseFileAndGetFirstNodeOfType(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, string $nodeType) : \_PhpScopere8e811afab72\PhpParser\Node
    {
        $nodes = $this->fileInfoParser->parseFileInfoToNodesAndDecorate($fileInfo);
        return $this->betterNodeFinder->findFirstInstanceOf($nodes, $nodeType);
    }
    private function printNodePhpDocInfoToString(\_PhpScopere8e811afab72\PhpParser\Node $node) : string
    {
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $this->phpDocInfoPrinter->printFormatPreserving($phpDocInfo);
    }
    private function createErrorMessage(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : string
    {
        return 'Caused by: ' . $fileInfo->getRelativeFilePathFromCwd() . \PHP_EOL;
    }
    private function doTestContainsTagValueNodeType(\_PhpScopere8e811afab72\PhpParser\Node $node, string $tagValueNodeType, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $this->assertTrue($phpDocInfo->hasByType($tagValueNodeType), $fileInfo->getRelativeFilePathFromCwd());
    }
}
