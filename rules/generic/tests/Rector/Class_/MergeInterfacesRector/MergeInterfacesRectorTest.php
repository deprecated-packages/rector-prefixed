<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\Class_\MergeInterfacesRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeInterface;
use _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeOldInterface;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class MergeInterfacesRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\Class_\MergeInterfacesRector::class => [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\Class_\MergeInterfacesRector::OLD_TO_NEW_INTERFACES => [\_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeOldInterface::class => \_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeInterface::class]]];
    }
}
