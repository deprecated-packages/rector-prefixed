<?php

declare (strict_types=1);
namespace Rector\DeadCode\Tests\Rector\If_\UnwrapFutureCompatibleIfPhpVersionRector;

use Iterator;
use Rector\DeadCode\Rector\If_\UnwrapFutureCompatibleIfPhpVersionRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210217\Symplify\SmartFileSystem\SmartFileInfo;
final class UnwrapFutureCompatibleIfPhpVersionRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210217\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DeadCode\Rector\If_\UnwrapFutureCompatibleIfPhpVersionRector::class;
    }
}
