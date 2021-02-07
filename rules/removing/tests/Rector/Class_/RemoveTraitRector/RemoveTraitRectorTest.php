<?php

declare (strict_types=1);
namespace Rector\Removing\Tests\Rector\Class_\RemoveTraitRector;

use Iterator;
use Rector\Removing\Rector\Class_\RemoveTraitRector;
use Rector\Removing\Tests\Rector\Class_\RemoveTraitRector\Source\TraitToBeRemoved;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210207\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveTraitRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210207\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\Rector\Removing\Rector\Class_\RemoveTraitRector::class => [\Rector\Removing\Rector\Class_\RemoveTraitRector::TRAITS_TO_REMOVE => [\Rector\Removing\Tests\Rector\Class_\RemoveTraitRector\Source\TraitToBeRemoved::class]]];
    }
}
