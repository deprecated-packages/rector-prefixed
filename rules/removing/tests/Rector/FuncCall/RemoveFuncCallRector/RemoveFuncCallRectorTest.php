<?php

declare (strict_types=1);
namespace Rector\Removing\Tests\Rector\FuncCall\RemoveFuncCallRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use SplFileInfo;
use RectorPrefix20210301\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveFuncCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210301\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    /**
     * @return Iterator<SplFileInfo>
     */
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function provideConfigFilePath() : string
    {
        return __DIR__ . '/config/configured_rule.php';
    }
}
