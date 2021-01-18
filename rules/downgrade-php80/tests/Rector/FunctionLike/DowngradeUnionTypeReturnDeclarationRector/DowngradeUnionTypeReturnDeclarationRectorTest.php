<?php

declare (strict_types=1);
namespace Rector\DowngradePhp80\Tests\Rector\FunctionLike\DowngradeUnionTypeReturnDeclarationRector;

use Iterator;
use Rector\DowngradePhp80\Rector\FunctionLike\DowngradeUnionTypeReturnDeclarationRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210118\Symplify\SmartFileSystem\SmartFileInfo;
final class DowngradeUnionTypeReturnDeclarationRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     * @requires PHP 8.0
     */
    public function test(\RectorPrefix20210118\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DowngradePhp80\Rector\FunctionLike\DowngradeUnionTypeReturnDeclarationRector::class;
    }
}
