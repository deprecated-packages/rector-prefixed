<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\ChangeContractMethodSingleToManyRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeContractMethodSingleToManyRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\ChangeContractMethodSingleToManyRector\Source\OneToManyInterface;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeContractMethodSingleToManyRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeContractMethodSingleToManyRector::class => [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeContractMethodSingleToManyRector::OLD_TO_NEW_METHOD_BY_TYPE => [\_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\ChangeContractMethodSingleToManyRector\Source\OneToManyInterface::class => ['getNode' => 'getNodes']]]];
    }
}
