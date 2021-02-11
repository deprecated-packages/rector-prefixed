<?php

declare (strict_types=1);
namespace Rector\DowngradePhp74\Tests\Rector\ClassMethod\DowngradeReturnSelfTypeDeclarationRector;

use Iterator;
use Rector\DowngradePhp74\Rector\ClassMethod\DowngradeReturnSelfTypeDeclarationRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210211\Symplify\SmartFileSystem\SmartFileInfo;
final class DowngradeReturnSelfTypeDeclarationRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 7.4
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210211\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DowngradePhp74\Rector\ClassMethod\DowngradeReturnSelfTypeDeclarationRector::class;
    }
}
