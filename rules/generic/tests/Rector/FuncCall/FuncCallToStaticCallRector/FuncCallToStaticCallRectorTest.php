<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\FuncCall\FuncCallToStaticCallRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Rector\Transform\ValueObject\FuncCallToStaticCall;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class FuncCallToStaticCallRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector::class => [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector::FUNC_CALLS_TO_STATIC_CALLS => [new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\FuncCallToStaticCall('view', 'SomeStaticClass', 'render'), new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\FuncCallToStaticCall('_PhpScoperb75b35f52b74\\SomeNamespaced\\view', 'AnotherStaticClass', 'render')]]];
    }
}
