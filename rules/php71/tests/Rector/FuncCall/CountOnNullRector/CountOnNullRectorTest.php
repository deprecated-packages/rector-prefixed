<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php71\Tests\Rector\FuncCall\CountOnNullRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoperb75b35f52b74\Rector\Php71\Rector\FuncCall\CountOnNullRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class CountOnNullRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoperb75b35f52b74\Rector\Php71\Rector\FuncCall\CountOnNullRector::class;
    }
    protected function getPhpVersion() : int
    {
        return \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::COUNT_ON_NULL;
    }
}
