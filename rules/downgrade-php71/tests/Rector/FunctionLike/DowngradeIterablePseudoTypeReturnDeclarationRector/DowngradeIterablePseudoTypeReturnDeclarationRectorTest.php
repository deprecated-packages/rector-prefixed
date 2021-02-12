<?php

declare (strict_types=1);
namespace Rector\DowngradePhp71\Tests\Rector\FunctionLike\DowngradeIterablePseudoTypeReturnDeclarationRector;

use Iterator;
use Rector\DowngradePhp71\Rector\FunctionLike\DowngradeIterablePseudoTypeReturnDeclarationRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210212\Symplify\SmartFileSystem\SmartFileInfo;
final class DowngradeIterablePseudoTypeReturnDeclarationRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210212\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DowngradePhp71\Rector\FunctionLike\DowngradeIterablePseudoTypeReturnDeclarationRector::class;
    }
}
