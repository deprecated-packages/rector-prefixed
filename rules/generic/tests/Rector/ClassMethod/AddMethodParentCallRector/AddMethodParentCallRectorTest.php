<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\ClassMethod\AddMethodParentCallRector;

use Iterator;
use Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector;
use Rector\Generic\Tests\Rector\ClassMethod\AddMethodParentCallRector\Source\ParentClassWithNewConstructor;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201231\Symplify\SmartFileSystem\SmartFileInfo;
final class AddMethodParentCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201231\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::class => [\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::METHODS_BY_PARENT_TYPES => [\Rector\Generic\Tests\Rector\ClassMethod\AddMethodParentCallRector\Source\ParentClassWithNewConstructor::class => '__construct']]];
    }
}
