<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Expression\MethodCallToReturnRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\Expression\MethodCallToReturnRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Expression\MethodCallToReturnRector\Source\ReturnDeny;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\MethodCallToReturn;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class MethodCallToReturnRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\Expression\MethodCallToReturnRector::class => [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\Expression\MethodCallToReturnRector::METHOD_CALL_WRAPS => [new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\MethodCallToReturn(\_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Expression\MethodCallToReturnRector\Source\ReturnDeny::class, 'deny')]]];
    }
}
