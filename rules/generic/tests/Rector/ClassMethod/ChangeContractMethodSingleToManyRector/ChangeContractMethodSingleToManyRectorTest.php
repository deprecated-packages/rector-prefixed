<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\ClassMethod\ChangeContractMethodSingleToManyRector;

use Iterator;
use Rector\Generic\Rector\ClassMethod\ChangeContractMethodSingleToManyRector;
use Rector\Generic\Tests\Rector\ClassMethod\ChangeContractMethodSingleToManyRector\Source\OneToManyInterface;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210114\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeContractMethodSingleToManyRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210114\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Generic\Rector\ClassMethod\ChangeContractMethodSingleToManyRector::class => [\Rector\Generic\Rector\ClassMethod\ChangeContractMethodSingleToManyRector::OLD_TO_NEW_METHOD_BY_TYPE => [\Rector\Generic\Tests\Rector\ClassMethod\ChangeContractMethodSingleToManyRector\Source\OneToManyInterface::class => ['getNode' => 'getNodes']]]];
    }
}
