<?php

declare (strict_types=1);
namespace Rector\PHPStan\Tests\Rector\Cast\RecastingRemovalRector;

use Iterator;
use Rector\PHPStan\Rector\Cast\RecastingRemovalRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class RecastingRemovalRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\PHPStan\Rector\Cast\RecastingRemovalRector::class;
    }
}
