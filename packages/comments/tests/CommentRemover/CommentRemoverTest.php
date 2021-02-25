<?php

declare (strict_types=1);
namespace Rector\Comments\Tests\CommentRemover;

use Iterator;
use Rector\Comments\CommentRemover;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\FileSystemRector\Parser\FileInfoParser;
use RectorPrefix20210225\Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use RectorPrefix20210225\Symplify\EasyTesting\StaticFixtureSplitter;
use RectorPrefix20210225\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use RectorPrefix20210225\Symplify\SmartFileSystem\SmartFileInfo;
final class CommentRemoverTest extends \RectorPrefix20210225\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var CommentRemover
     */
    private $commentRemover;
    /**
     * @var FileInfoParser
     */
    private $fileInfoParser;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    protected function setUp() : void
    {
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->commentRemover = $this->getService(\Rector\Comments\CommentRemover::class);
        $this->fileInfoParser = $this->getService(\Rector\FileSystemRector\Parser\FileInfoParser::class);
        $this->betterStandardPrinter = $this->getService(\Rector\Core\PhpParser\Printer\BetterStandardPrinter::class);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210225\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $fileInfoToLocalInputAndExpected = \RectorPrefix20210225\Symplify\EasyTesting\StaticFixtureSplitter::splitFileInfoToLocalInputAndExpected($smartFileInfo);
        $nodes = $this->fileInfoParser->parseFileInfoToNodesAndDecorate($fileInfoToLocalInputAndExpected->getInputFileInfo());
        $nodesWithoutComments = $this->commentRemover->removeFromNode($nodes);
        $fileContent = $this->betterStandardPrinter->print($nodesWithoutComments);
        $fileContent = \trim($fileContent);
        $expectedContent = \trim($fileInfoToLocalInputAndExpected->getExpected());
        $this->assertSame($fileContent, $expectedContent, $smartFileInfo->getRelativeFilePathFromCwd());
        // original nodes are not touched
        $originalContent = $this->betterStandardPrinter->print($nodes);
        $this->assertNotSame($expectedContent, $originalContent);
    }
    public function provideData() : \Iterator
    {
        return \RectorPrefix20210225\Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectory(__DIR__ . '/Fixture', '*.php.inc');
    }
}
