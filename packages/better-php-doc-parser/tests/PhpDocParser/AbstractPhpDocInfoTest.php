<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser;

use Iterator;
use PhpParser\Node;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter;
use Rector\BetterPhpDocParser\Tests\PhpDocParser\Helper\TagValueToPhpParserNodeMap;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\FileSystemRector\Parser\FileInfoParser;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
abstract class AbstractPhpDocInfoTest extends \Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->fileInfoParser = $this->getService(\Rector\FileSystemRector\Parser\FileInfoParser::class);
        $this->betterNodeFinder = $this->getService(\Rector\Core\PhpParser\Node\BetterNodeFinder::class);
        $this->phpDocInfoPrinter = $this->getService(\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter::class);
    }
    /**
     * @param class-string $tagValueNodeType
     */
    protected function doTestPrintedPhpDocInfo(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, string $tagValueNodeType) : void
    {
        if (!isset(\Rector\BetterPhpDocParser\Tests\PhpDocParser\Helper\TagValueToPhpParserNodeMap::MAP[$tagValueNodeType])) {
            throw new \Rector\Core\Exception\ShouldNotHappenException(\sprintf('[tests] Add "%s" to %s::%s constant', $tagValueNodeType, \Rector\BetterPhpDocParser\Tests\PhpDocParser\Helper\TagValueToPhpParserNodeMap::class, 'MAP'));
        }
        $nodeType = \Rector\BetterPhpDocParser\Tests\PhpDocParser\Helper\TagValueToPhpParserNodeMap::MAP[$tagValueNodeType];
        $nodeWithPhpDocInfo = $this->parseFileAndGetFirstNodeOfType($fileInfo, $nodeType);
        $docComment = $nodeWithPhpDocInfo->getDocComment();
        if ($docComment === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException(\sprintf('Doc comments for "%s" file cannot not be empty', $fileInfo));
        }
        $originalDocCommentText = $docComment->getText();
        $printedPhpDocInfo = $this->printNodePhpDocInfoToString($nodeWithPhpDocInfo);
        $errorMessage = $this->createErrorMessage($fileInfo);
        $this->assertSame($originalDocCommentText, $printedPhpDocInfo, $errorMessage);
        $this->doTestContainsTagValueNodeType($nodeWithPhpDocInfo, $tagValueNodeType, $fileInfo);
    }
    protected function yieldFilesFromDirectory(string $directory, string $suffix = '*.php') : \Iterator
    {
        return \Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectory($directory, $suffix);
    }
    protected function findFilesFromDirectory(string $directory, string $suffix = '*.php') : \Iterator
    {
        return \Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectory($directory, $suffix);
    }
    /**
     * @param class-string $nodeType
     */
    private function parseFileAndGetFirstNodeOfType(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, string $nodeType) : \PhpParser\Node
    {
        $nodes = $this->fileInfoParser->parseFileInfoToNodesAndDecorate($fileInfo);
        return $this->betterNodeFinder->findFirstInstanceOf($nodes, $nodeType);
    }
    private function printNodePhpDocInfoToString(\PhpParser\Node $node) : string
    {
        $phpDocInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        return $this->phpDocInfoPrinter->printFormatPreserving($phpDocInfo);
    }
    private function createErrorMessage(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : string
    {
        return 'Caused by: ' . $fileInfo->getRelativeFilePathFromCwd() . \PHP_EOL;
    }
    private function doTestContainsTagValueNodeType(\PhpParser\Node $node, string $tagValueNodeType, \Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $this->assertTrue($phpDocInfo->hasByType($tagValueNodeType), $fileInfo->getRelativeFilePathFromCwd());
    }
}
