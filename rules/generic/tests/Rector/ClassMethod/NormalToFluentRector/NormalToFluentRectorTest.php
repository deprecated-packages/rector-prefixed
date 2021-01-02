<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\ClassMethod\NormalToFluentRector;

use Iterator;
use Rector\Generic\Rector\ClassMethod\NormalToFluentRector;
use Rector\Generic\Tests\Rector\ClassMethod\NormalToFluentRector\Source\FluentInterfaceClass;
use Rector\Generic\ValueObject\NormalToFluent;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210102\Symplify\SmartFileSystem\SmartFileInfo;
final class NormalToFluentRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\Rector\Generic\Rector\ClassMethod\NormalToFluentRector::class => [\Rector\Generic\Rector\ClassMethod\NormalToFluentRector::CALLS_TO_FLUENT => [new \Rector\Generic\ValueObject\NormalToFluent(\Rector\Generic\Tests\Rector\ClassMethod\NormalToFluentRector\Source\FluentInterfaceClass::class, ['someFunction', 'otherFunction', 'joinThisAsWell'])]]];
    }
}
