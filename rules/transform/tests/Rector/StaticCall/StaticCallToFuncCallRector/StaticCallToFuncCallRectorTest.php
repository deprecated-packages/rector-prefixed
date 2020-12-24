<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\StaticCall\StaticCallToFuncCallRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector;
use _PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\StaticCall\StaticCallToFuncCallRector\Source\SomeOldStaticClass;
use _PhpScoperb75b35f52b74\Rector\Transform\ValueObject\StaticCallToFuncCall;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class StaticCallToFuncCallRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector::class => [\_PhpScoperb75b35f52b74\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector::STATIC_CALLS_TO_FUNCTIONS => [new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\StaticCallToFuncCall(\_PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\StaticCall\StaticCallToFuncCallRector\Source\SomeOldStaticClass::class, 'render', 'view')]]];
    }
}
