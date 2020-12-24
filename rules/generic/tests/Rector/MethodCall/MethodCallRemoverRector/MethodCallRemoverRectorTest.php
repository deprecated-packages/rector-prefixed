<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\MethodCall\MethodCallRemoverRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\MethodCall\MethodCallRemoverRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class MethodCallRemoverRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\MethodCall\MethodCallRemoverRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\MethodCall\MethodCallRemoverRector::METHOD_CALL_REMOVER_ARGUMENT => ['_PhpScopere8e811afab72\\Rector\\Generic\\Tests\\Rector\\MethodCall\\MethodCallRemoverRector\\Source\\Car' => 'getCarType']]];
    }
}
