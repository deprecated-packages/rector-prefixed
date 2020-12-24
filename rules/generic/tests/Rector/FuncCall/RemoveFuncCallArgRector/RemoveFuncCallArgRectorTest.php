<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\FuncCall\RemoveFuncCallArgRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\RemoveFuncCallArg;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use SplFileInfo;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveFuncCallArgRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    /**
     * @return Iterator<SplFileInfo>
     */
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector::REMOVED_FUNCTION_ARGUMENTS => [new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\RemoveFuncCallArg('ldap_first_attribute', 2)]]];
    }
}
