<?php

declare (strict_types=1);
namespace Rector\Php74\Tests\Rector\Property\TypedPropertyRector;

use Iterator;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210312\Symplify\SmartFileSystem\SmartFileInfo;
final class UnionTypedPropertyRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210312\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureUnionTypes');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php74\Rector\Property\TypedPropertyRector::class;
    }
}
