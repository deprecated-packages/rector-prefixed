<?php

declare (strict_types=1);
namespace Rector\Core\Tests\PhpParser\Printer\CommentRemover;

use Iterator;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\Core\PhpParser\Printer\CommentRemover;
use Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use Symplify\EasyTesting\StaticFixtureSplitter;
use Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class CommentRemoverTest extends \Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var CommentRemover
     */
    private $commentRemover;
    protected function setUp() : void
    {
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->commentRemover = static::$container->get(\Rector\Core\PhpParser\Printer\CommentRemover::class);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $inputAndExpected = \Symplify\EasyTesting\StaticFixtureSplitter::splitFileInfoToInputAndExpected($smartFileInfo);
        $removedContent = $this->commentRemover->remove($inputAndExpected->getInput());
        $this->assertSame($inputAndExpected->getExpected(), $removedContent, $smartFileInfo->getRelativeFilePathFromCwd());
    }
    public function provideData() : \Iterator
    {
        return \Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectory(__DIR__ . '/Fixture', '*.php.inc');
    }
}
