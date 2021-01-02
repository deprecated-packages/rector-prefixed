<?php

declare (strict_types=1);
namespace Rector\Restoration\Tests\Rector\New_\CompleteMissingDependencyInNewRector;

use Iterator;
use Rector\Restoration\Rector\New_\CompleteMissingDependencyInNewRector;
use Rector\Restoration\Tests\Rector\New_\CompleteMissingDependencyInNewRector\Source\RandomDependency;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210102\Symplify\SmartFileSystem\SmartFileInfo;
final class CompleteMissingDependencyInNewRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210102\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Restoration\Rector\New_\CompleteMissingDependencyInNewRector::class => [\Rector\Restoration\Rector\New_\CompleteMissingDependencyInNewRector::CLASS_TO_INSTANTIATE_BY_TYPE => [\Rector\Restoration\Tests\Rector\New_\CompleteMissingDependencyInNewRector\Source\RandomDependency::class => \Rector\Restoration\Tests\Rector\New_\CompleteMissingDependencyInNewRector\Source\RandomDependency::class]]];
    }
}
