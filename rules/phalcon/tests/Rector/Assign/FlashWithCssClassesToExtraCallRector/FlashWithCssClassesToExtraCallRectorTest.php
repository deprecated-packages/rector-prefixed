<?php

declare (strict_types=1);
namespace Rector\Phalcon\Tests\Rector\Assign\FlashWithCssClassesToExtraCallRector;

use Iterator;
use Rector\Phalcon\Rector\Assign\FlashWithCssClassesToExtraCallRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210117\Symplify\SmartFileSystem\SmartFileInfo;
final class FlashWithCssClassesToExtraCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210117\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Phalcon\Rector\Assign\FlashWithCssClassesToExtraCallRector::class;
    }
}
