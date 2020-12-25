<?php

declare (strict_types=1);
namespace Rector\SOLID\Tests\Rector\Class_\MultiParentingToAbstractDependencyRector;

use Iterator;
use Rector\SOLID\Rector\Class_\MultiParentingToAbstractDependencyRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class MultiParentingToAbstractDependencyRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\Rector\SOLID\Rector\Class_\MultiParentingToAbstractDependencyRector::class => [\Rector\SOLID\Rector\Class_\MultiParentingToAbstractDependencyRector::FRAMEWORK => 'nette']];
    }
}
